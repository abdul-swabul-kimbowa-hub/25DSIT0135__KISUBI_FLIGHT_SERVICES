<?php
$page_title = 'Manage Users | Kisubi Airlines';
require_once __DIR__ . '/auth.php';

$users = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
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
            <a class="nav-link nav-link-active" href="users.php">Users</a>
            <a class="nav-link" href="reports.php">Reports</a>
            <a class="nav-link nav-cta" href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="section">
        <h1 class="section-title">Users</h1>
        <div class="glass-panel" style="padding:16px;">
            <table style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                <thead>
                <tr style="text-align:left; color:#9ca3af;">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['name']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['role']); ?></td>
                        <td><?php echo htmlspecialchars($u['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

