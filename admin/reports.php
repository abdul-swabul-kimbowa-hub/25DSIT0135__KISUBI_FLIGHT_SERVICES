<?php
$page_title = 'Reports | Kisubi Airlines';
require_once __DIR__ . '/auth.php';

$bookingsByMonth = $pdo->query(
    "SELECT DATE_FORMAT(created_at, '%Y-%m') AS m, COUNT(*) AS c, COALESCE(SUM(total_price),0) AS revenue
     FROM bookings
     GROUP BY m
     ORDER BY m DESC
     LIMIT 12"
)->fetchAll();

$topRoutes = $pdo->query(
    "SELECT f.origin, f.destination, COUNT(*) AS c
     FROM bookings b
     JOIN flights f ON b.flight_id = f.id
     GROUP BY f.origin, f.destination
     ORDER BY c DESC
     LIMIT 10"
)->fetchAll();
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
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="flights.php">Flights</a>
            <a class="nav-link" href="bookings.php">Bookings</a>
            <a class="nav-link" href="users.php">Users</a>
            <a class="nav-link nav-link-active" href="reports.php">Reports</a>
            <a class="nav-link nav-cta" href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="section">
        <h1 class="section-title">Reports</h1>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:16px;">
            <div class="glass-panel" style="padding:16px;">
                <h2 style="margin-top:0; font-size:1rem;">Bookings & revenue by month</h2>
                <table style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                    <thead>
                    <tr style="text-align:left; color:#9ca3af;">
                        <th>Month</th>
                        <th>Bookings</th>
                        <th>Revenue (UGX)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($bookingsByMonth as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['m']); ?></td>
                            <td><?php echo (int)$row['c']; ?></td>
                            <td><?php echo number_format($row['revenue']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="glass-panel" style="padding:16px;">
                <h2 style="margin-top:0; font-size:1rem;">Top routes</h2>
                <table style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                    <thead>
                    <tr style="text-align:left; color:#9ca3af;">
                        <th>Route</th>
                        <th>Bookings</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($topRoutes as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['origin']); ?> → <?php echo htmlspecialchars($row['destination']); ?></td>
                            <td><?php echo (int)$row['c']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>

