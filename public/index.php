<?php
// Bootstrap sessions early so controllers and views can use $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    // Set safer cookie params (compatible with HTTP dev environments)
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookieParams['path'] ?? '/',
        'domain' => $cookieParams['domain'] ?? '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once '../core/Router.php';
Router::route();
