<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';

// Prevent browser caching of admin pages (fixes Back-button after logout)
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

