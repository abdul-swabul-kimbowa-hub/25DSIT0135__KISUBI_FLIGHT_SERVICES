<?php
$page_title = 'Flight Timetable | Kisubi Airlines';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/partials/header.php';

// All upcoming flights from today, ordered by date/time
$stmt = $pdo->query(
    "SELECT * FROM flights
     WHERE departure_time >= CURDATE()
     ORDER BY DATE(departure_time) ASC, TIME(departure_time) ASC"
);
$flights = $stmt->fetchAll();
?>

<main class="section">
    <h1 class="section-title">Flight timetable</h1>

    <?php if (!$flights): ?>
        <p style="color:#64748b;">No flights are scheduled yet. Add flights from the admin panel.</p>
    <?php else: ?>
        <div class="glass-panel" style="padding:16px;">
            <table style="width:100%; border-collapse:collapse; font-size:0.84rem;">
                <thead>
                <tr style="text-align:left; color:#9ca3af;">
                    <th>Date</th>
                    <th>Flight</th>
                    <th>Route</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Cabin</th>
                    <th>From (UGX)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($flights as $f): ?>
                    <?php $depDate = substr($f['departure_time'], 0, 10); ?>
                    <tr>
                        <td><?php echo htmlspecialchars($depDate); ?></td>
                        <td><?php echo htmlspecialchars($f['flight_number']); ?></td>
                        <td><?php echo htmlspecialchars($f['origin']); ?> → <?php echo htmlspecialchars($f['destination']); ?></td>
                        <td><?php echo htmlspecialchars(substr($f['departure_time'], 11, 5)); ?></td>
                        <td><?php echo htmlspecialchars(substr($f['arrival_time'], 11, 5)); ?></td>
                        <td><?php echo htmlspecialchars($f['cabin']); ?></td>
                        <td>UGX <?php echo number_format($f['base_price']); ?></td>
                        <td>
                            <a class="btn-secondary"
                               href="search_results.php?origin=<?php echo urlencode($f['origin']); ?>
&destination=<?php echo urlencode($f['destination']); ?>
&departure_date=<?php echo urlencode($depDate); ?>&cabin=<?php echo urlencode($f['cabin']); ?>&passengers=1">
                                Book
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

