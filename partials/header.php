<?php
if (!isset($page_title)) {
    $page_title = 'Kisubi Airlines';
}
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
    <header class="navbar">
        <a href="<?php echo BASE_URL; ?>index.php" class="navbar-brand">
            <span class="navbar-brand-badge"></span>
            <span>Kisubi Airlines</span>
        </a>
        <nav class="nav-links">
            <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Home</a>
            <a class="nav-link" href="<?php echo BASE_URL; ?>search_results.php">Book</a>
            <a class="nav-link" href="<?php echo BASE_URL; ?>timetable.php">Timetable</a>
            <a class="nav-link" href="<?php echo BASE_URL; ?>baggage.php">Baggage</a>
            <a class="nav-link" href="<?php echo BASE_URL; ?>my_bookings.php">My Bookings</a>
            <a class="nav-link" href="<?php echo BASE_URL; ?>about.php">About</a>
            <a class="nav-link" href="<?php echo BASE_URL; ?>contact.php">Contact</a>
            <a class="nav-link nav-cta" href="<?php echo BASE_URL; ?>admin/index.php">Admin</a>
        </nav>
    </header>

