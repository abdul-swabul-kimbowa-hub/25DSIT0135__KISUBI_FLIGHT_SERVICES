<?php
$page_title = 'Manage Bookings | Kisubi Airlines';
require_once __DIR__ . '/auth.php';

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_status') {
    $id = (int)($_POST['booking_id'] ?? 0);
    $status = $_POST['status'] ?? 'Pending';
    $stmt = $pdo->prepare("UPDATE bookings SET status = :s WHERE id = :id");
    $stmt->execute([':s' => $status, ':id' => $id]);
}

$bookings = $pdo->query(
    "SELECT b.*, f.flight_number, f.origin, f.destination
     FROM bookings b
     JOIN flights f ON b.flight_id = f.id
     ORDER BY b.created_at DESC
     LIMIT 100"
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
            <a class="nav-link nav-link-active" href="bookings.php">Bookings</a>
            <a class="nav-link" href="users.php">Users</a>
            <a class="nav-link" href="reports.php">Reports</a>
            <a class="nav-link nav-cta" href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="section">
        <h1 class="section-title">Bookings</h1>
        <div class="glass-panel" style="padding:16px;">
            <table style="width:100%; border-collapse:collapse; font-size:0.8rem;">
                <thead>
                <tr style="text-align:left; color:#9ca3af;">
                    <th>Ref</th>
                    <th>Customer</th>
                    <th>Flight</th>
                    <th>Route</th>
                    <th>Pax</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['booking_ref']); ?></td>
                        <td><?php echo htmlspecialchars($b['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($b['flight_number']); ?></td>
                        <td><?php echo htmlspecialchars($b['origin']); ?> → <?php echo htmlspecialchars($b['destination']); ?></td>
                        <td><?php echo (int)$b['passengers_count']; ?></td>
                        <td>UGX <?php echo number_format($b['total_price']); ?></td>
                        <td><?php echo htmlspecialchars($b['status']); ?></td>
                        <td><?php echo htmlspecialchars($b['created_at']); ?></td>
                        <td>
                            <form method="post" style="display:flex; gap:4px; align-items:center;">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                <select name="status" class="form-select" style="padding:4px 6px; font-size:0.75rem;">
                                    <?php foreach (['Pending','Confirmed','Cancelled','Checked-in'] as $s): ?>
                                        <option value="<?php echo $s; ?>" <?php if ($b['status'] === $s) echo 'selected'; ?>>
                                            <?php echo $s; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn-secondary" style="padding:4px 8px; font-size:0.75rem;">Save</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>

