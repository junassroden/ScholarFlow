<?php
session_start();

// Go up 3 levels: app/API -> app -> root
require_once __DIR__ . '/../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $email_confirmation = trim($_POST['email_confirmation'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['password_confirmation'] ?? '';
    $terms = isset($_POST['terms']);

    $errors = [];

    if (empty($first_name) || empty($last_name) || empty($username) || empty($phone) || empty($email) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    if ($email !== $email_confirmation) {
        $errors[] = "Email addresses do not match.";
    }

    if ($password !== $password_confirmation) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (!$terms) {
        $errors[] = "You must accept the Terms & Conditions.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: ../forms/create.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['errors'] = ["Username or email is already taken."];
            $_SESSION['old'] = $_POST;
            header("Location: ../forms/create.php");
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $pdo->beginTransaction();

        $userStmt = $pdo->prepare("INSERT INTO users (username, email, password, phone, created_at) VALUES (?, ?, ?, ?, NOW())");
        $userStmt->execute([$username, $email, $hashed_password, $phone]);
        $userId = $pdo->lastInsertId();

        $profileStmt = $pdo->prepare("INSERT INTO profiles (user_id, first_name, last_name) VALUES (?, ?, ?)");
        $profileStmt->execute([$userId, $first_name, $last_name]);

        $pdo->commit();

        header("Location: ../forms/login.php?registered=success");
        exit;

    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['errors'] = ["Database error: " . $e->getMessage()];
        $_SESSION['old'] = $_POST;
        header("Location: ../forms/create.php");
        exit;
    }
} else {
    header("Location: ../forms/create.php");
    exit;
}