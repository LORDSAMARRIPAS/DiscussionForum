<?php
function ensureCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

function getCsrfToken() {
    ensureCsrfToken();
    return $_SESSION['csrf_token'];
}

function validateCsrfToken($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(getCsrfToken()) . '">';
}

function requireCsrf() {
    $token = $_POST['csrf_token'] ?? '';
    if (!validateCsrfToken($token)) {
        header('HTTP/1.1 403 Forbidden');
        echo 'Invalid or missing CSRF token.';
        exit();
    }
}
