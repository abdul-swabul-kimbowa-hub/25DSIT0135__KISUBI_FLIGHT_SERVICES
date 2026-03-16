<?php
$page_title = 'Manage Flights | Kisubi Airlines';
require_once __DIR__ . '/auth.php';

$error = '';

// Handle create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create') {
    $flight_number = trim($_POST['flight_number'] ?? '');
    $origin = trim($_POST['origin'] ?? '');
    $destination = trim($_POST['destination'] ?? '');
    $departure_time = $_POST['departure_time'] ?? '';
    $arrival_time = $_POST['arrival_time'] ?? '';
    $cabin = $_POST['cabin'] ?? 'Economy';
    $base_price = (float)($_POST['base_price'] ?? 0);
    $total_seats = (int)($_POST['total_seats'] ?? 0);

    if (!$flight_number || !$origin || !$destination || !$departure_time || !$arrival_time || $total_seats <= 0) {
        $error = 'Please fill in all required fields.';
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO flights (flight_number, origin, destination, departure_time, arrival_time, cabin, base_price, total_seats, available_seats, status)
             VALUES (:fn, :o, :d, :dt, :at, :c, :bp, :ts, :ts, 'Scheduled')"
        );
        $stmt->execute([
            ':fn' => $flight_number,
            ':o' => $origin,
            ':d' => $destination,
            ':dt' => $departure_time,
            ':at' => $arrival_time,
            ':c' => $cabin,
            ':bp' => $base_price,
            ':ts' => $total_seats,
        ]);
    }
}

// Handle delete (simple)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM flights WHERE id = :id")->execute([':id' => $id]);
    header('Location: flights.php');
    exit;
}

$flights = $pdo->query("SELECT * FROM flights ORDER BY departure_time DESC")->fetchAll();
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
            <a class="nav-link nav-link-active" href="flights.php">Flights</a>
            <a class="nav-link" href="bookings.php">Bookings</a>
            <a class="nav-link" href="users.php">Users</a>
            <a class="nav-link" href="reports.php">Reports</a>
            <a class="nav-link nav-cta" href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="section">
        <h1 class="section-title">Flights</h1>

        <form method="post" class="glass-panel" style="padding:16px; margin-bottom:20px;">
            <input type="hidden" name="action" value="create">
            <h2 style="margin-top:0; font-size:1rem;">Add new flight</h2>
            <?php if ($error): ?>
                <div style="margin-bottom:8px; color:#fca5a5;"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:10px;">
                <div>
                    <label class="form-label">Flight number</label>
                    <input class="form-input" type="text" name="flight_number" required>
                </div>
                <div>
                    <label class="form-label">Origin</label>
                    <input class="form-input" type="text" name="origin" required>
                </div>
                <div>
                    <label class="form-label">Destination</label>
                    <input class="form-input" type="text" name="destination" required>
                </div>
                <div>
                    <label class="form-label">Departure</label>
                    <input class="form-input" type="datetime-local" name="departure_time" required>
                </div>
                <div>
                    <label class="form-label">Arrival</label>
                    <input class="form-input" type="datetime-local" name="arrival_time" required>
                </div>
                <div>
                    <label class="form-label">Cabin</label>
                    <select class="form-select" name="cabin">
                        <option value="Economy">Economy</option>
                        <option value="Business">Business</option>
                        <option value="First">First</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Base price (UGX)</label>
                    <input class="form-input" type="number" name="base_price" step="0.01" required>
                </div>
                <div>
                    <label class="form-label">Total seats</label>
                    <input class="form-input" type="number" name="total_seats" min="1" required>
                </div>
            </div>
            <button type="submit" class="btn-primary" style="margin-top:10px;">Create flight</button>
        </form>

        <div class="glass-panel" style="padding:16px;">
            <h2 style="margin-top:0; font-size:1rem;">Existing flights</h2>
            <table style="width:100%; border-collapse:collapse; font-size:0.82rem;">
                <thead>
                <tr style="text-align:left; color:#9ca3af;">
                    <th>Flight</th>
                    <th>Route</th>
                    <th>Departure</th>
                    <th>Cabin</th>
                    <th>Seats</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($flights as $f): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($f['flight_number']); ?></td>
                        <td><?php echo htmlspecialchars($f['origin']); ?> → <?php echo htmlspecialchars($f['destination']); ?></td>
                        <td><?php echo htmlspecialchars($f['departure_time']); ?></td>
                        <td><?php echo htmlspecialchars($f['cabin']); ?></td>
                        <td><?php echo (int)$f['available_seats']; ?>/<?php echo (int)$f['total_seats']; ?></td>
                        <td>UGX <?php echo number_format($f['base_price']); ?></td>
                        <td>
                            <a class="btn-secondary" href="flights.php?delete=<?php echo $f['id']; ?>"
                               onclick="return confirm('Delete this flight?')">Delete</a>
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

