<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: ../index.php');
        exit;
    }
}
function require_admin() {
    require_login();
    if ($_SESSION['user']['peran'] !== 'admin') {
        header('Location: ../dashboard/index.php?error=forbidden');
        exit;
    }
}
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
