<?php
$page_title = 'Admin Dashboard | Kisubi Airlines';
require_once __DIR__ . '/auth.php';

// Simple stats
$totalFlights = $pdo->query("SELECT COUNT(*) AS c FROM flights")->fetch()['c'] ?? 0;
$totalBookings = $pdo->query("SELECT COUNT(*) AS c FROM bookings")->fetch()['c'] ?? 0;
$totalRevenue = $pdo->query("SELECT COALESCE(SUM(total_price),0) AS s FROM bookings WHERE status IN ('Pending','Confirmed','Checked-in')")->fetch()['s'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
    <header class="navbar">
        <div class="navbar-brand">
            <span class="navbar-brand-badge"></span>
            <span>Admin · Kisubi</span>
        </div>
        <nav class="nav-links">
            <a class="nav-link nav-link-active" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="flights.php">Flights</a>
            <a class="nav-link" href="bookings.php">Bookings</a>
            <a class="nav-link" href="users.php">Users</a>
            <a class="nav-link" href="reports.php">Reports</a>
            <a class="nav-link nav-cta" href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="section">
        <h1 class="section-title">Overview</h1>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px;">
            <div class="glass-panel" style="padding:16px;">
                <div style="font-size:0.8rem; color:#9ca3af;">Total flights</div>
                <div style="font-size:1.6rem; font-weight:700;"><?php echo (int)$totalFlights; ?></div>
            </div>
            <div class="glass-panel" style="padding:16px;">
                <div style="font-size:0.8rem; color:#9ca3af;">Total bookings</div>
                <div style="font-size:1.6rem; font-weight:700;"><?php echo (int)$totalBookings; ?></div>
            </div>
            <div class="glass-panel" style="padding:16px;">
                <div style="font-size:0.8rem; color:#9ca3af;">Revenue (UGX)</div>
                <div style="font-size:1.6rem; font-weight:700;"><?php echo number_format($totalRevenue); ?></div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

