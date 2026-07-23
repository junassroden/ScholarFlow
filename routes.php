<?php
/**
 * All routes here
 */
// Home
$router->get('/', 'app/forms/index');

// Login
$router->get('/login', 'app/forms/login');
$router->post('/login', 'app/API/login_process');

// Create
$router->get('/create', 'app/forms/create');
$router->post('/create', 'app/API/create_process');