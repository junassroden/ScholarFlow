<?php
session_start();
// Include your database connection file here (e.g., config.php)
require_once '../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Check if the user is currently timed out (30 minutes)
    if (isset($_SESSION['locked_until'])) {
        if (time() < $_SESSION['locked_until']) {
            $remaining = ceil(($_SESSION['locked_until'] - time()) / 60);
            $_SESSION['error'] = "Too many failed attempts. Try again in $remaining minutes.";
            header("Location: ../forms/login.php");
            exit();
        } else {
            // Timeout expired, reset attempts
            unset($_SESSION['locked_until']);
            $_SESSION['login_attempts'] = 0;
        }
    }

    // Initialize attempts if not set
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // 2. Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Email not found
        $_SESSION['error'] = "Account don't exist";
        $_SESSION['login_attempts']++;
    } else {
        $user = $result->fetch_assoc();
        
        // 3. Verify Password
        if (password_verify($password, $user['password'])) {
            // Login Successful
            $_SESSION['login_attempts'] = 0; 
            $_SESSION['user_id'] = $user['id'];
            
            // Redirect to dashboard/home
            header("Location: ../views/homepage.php");
            exit();
        } else {
            // Password incorrect
            $_SESSION['error'] = "Wrong Password";
            $_SESSION['login_attempts']++;
        }
    }

    // 4. Trigger 30-minute timeout if 3 attempts are reached
    if ($_SESSION['login_attempts'] >= 3) {
        $_SESSION['locked_until'] = time() + (30 * 60); // Current time + 30 minutes
        $_SESSION['error'] = "Too many attempts. You are timed out for 30 minutes to avoid spam.";
    }

    // Redirect back to login UI to display the error
    header("Location: ../forms/login.php");
    exit();
}
?>