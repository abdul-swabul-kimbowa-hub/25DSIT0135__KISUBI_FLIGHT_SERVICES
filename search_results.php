<?php
$page_title = 'Search Flights | Kisubi Airlines';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/partials/header.php';

$origin = isset($_GET['origin']) ? trim($_GET['origin']) : '';
$destination = isset($_GET['destination']) ? trim($_GET['destination']) : '';
$departure_date = $_GET['departure_date'] ?? '';
$cabin = $_GET['cabin'] ?? '';
$passengers = isset($_GET['passengers']) ? (int)$_GET['passengers'] : 1;

$flights = [];
$otherDates = [];
if ($origin && $destination && $departure_date) {
    // First: exact date results
    $sql = "SELECT * FROM flights
            WHERE origin LIKE :origin
              AND destination LIKE :destination
              AND DATE(departure_time) = :dep
              AND available_seats >= :pax";
    $params = [
        ':origin' => '%' . $origin . '%',
        ':destination' => '%' . $destination . '%',
        ':dep' => $departure_date,
        ':pax' => $passengers,
    ];
    if ($cabin) {
        $sql .= " AND cabin = :cabin";
        $params[':cabin'] = $cabin;
    }
    $sql .= " ORDER BY departure_time ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $flights = $stmt->fetchAll();

    // If none on that date, or to show more options, also fetch other upcoming dates for same route
    $sqlOther = "SELECT * FROM flights
                 WHERE origin LIKE :origin2
                   AND destination LIKE :destination2
                   AND DATE(departure_time) >= CURDATE()
                   AND DATE(departure_time) <> :dep2
                   AND available_seats >= :pax2";
    $paramsOther = [
        ':origin2' => '%' . $origin . '%',
        ':destination2' => '%' . $destination . '%',
        ':dep2' => $departure_date,
        ':pax2' => $passengers,
    ];
    if ($cabin) {
        $sqlOther .= " AND cabin = :cabin2";
        $paramsOther[':cabin2'] = $cabin;
    }
    $sqlOther .= " ORDER BY departure_time ASC LIMIT 20";

    $stmtOther = $pdo->prepare($sqlOther);
    $stmtOther->execute($paramsOther);
    $otherDates = $stmtOther->fetchAll();
}
?>

<main class="section">
    <h1 class="section-title">Available flights</h1>

    <?php if (!$origin || !$destination || !$departure_date): ?>
        <p>Please go back and enter origin, destination and departure date.</p>
    <?php else: ?>
        <p style="margin-bottom:20px; color:#9ca3af;">
            From <strong><?php echo htmlspecialchars($origin); ?></strong> to
            <strong><?php echo htmlspecialchars($destination); ?></strong> on
            <strong><?php echo htmlspecialchars($departure_date); ?></strong>,
            for <?php echo $passengers; ?> passenger(s).
        </p>

        <?php if (!$flights && !$otherDates): ?>
            <p>No flights found for this route yet. Please try another destination or check the timetable.</p>
        <?php else: ?>
            <?php if ($flights): ?>
                <h2 style="font-size:1rem; margin:0 0 10px;">Flights on your selected date</h2>
                <div style="display:flex; flex-direction:column; gap:14px; margin-bottom:22px;">
                    <?php foreach ($flights as $flight): ?>
                        <article class="glass-panel" style="padding:14px 16px; display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <div style="font-size:0.9rem; color:#9ca3af;">
                                    Flight <?php echo htmlspecialchars($flight['flight_number']); ?>
                                    &middot; <?php echo htmlspecialchars($flight['cabin']); ?>
                                </div>
                                <div style="font-size:1rem; margin-top:4px;">
                                    <?php echo htmlspecialchars($flight['origin']); ?>
                                    &rarr; <?php echo htmlspecialchars($flight['destination']); ?>
                                </div>
                                <div style="font-size:0.8rem; color:#9ca3af; margin-top:4px;">
                                    Departs: <?php echo htmlspecialchars($flight['departure_time']); ?>
                                    &middot;
                                    Arrives: <?php echo htmlspecialchars($flight['arrival_time']); ?>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-weight:700; font-size:1rem;">
                                    UGX <?php echo number_format($flight['base_price'] * max(1, $passengers)); ?>
                                </div>
                                <div style="font-size:0.8rem; color:#9ca3af;">
                                    <?php echo $passengers; ?> pax &middot;
                                    <?php echo (int)$flight['available_seats']; ?> seats left
                                </div>
                                <a class="btn-primary" style="margin-top:8px; display:inline-block; text-align:center;"
                                   href="booking.php?flight_id=<?php echo $flight['id']; ?>&passengers=<?php echo $passengers; ?>">
                                    Select
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($otherDates): ?>
                <h2 style="font-size:1rem; margin:0 0 10px;">Other upcoming flights on this route</h2>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <?php foreach ($otherDates as $flight): ?>
                        <?php $depDate = substr($flight['departure_time'], 0, 10); ?>
                        <article class="glass-panel" style="padding:10px 12px; display:flex; justify-content:space-between; align-items:center; font-size:0.86rem;">
                            <div>
                                <div style="color:#64748b;">
                                    <?php echo htmlspecialchars($depDate); ?> ·
                                    Flight <?php echo htmlspecialchars($flight['flight_number']); ?>
                                </div>
                                <div>
                                    <?php echo htmlspecialchars($flight['origin']); ?>
                                    &rarr; <?php echo htmlspecialchars($flight['destination']); ?>
                                    &middot;
                                    Departs <?php echo htmlspecialchars(substr($flight['departure_time'], 11, 5)); ?>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <div>From UGX <?php echo number_format($flight['base_price']); ?></div>
                                <a class="btn-secondary" style="margin-top:4px; display:inline-block;"
                                   href="search_results.php?origin=<?php echo urlencode($flight['origin']); ?>
&destination=<?php echo urlencode($flight['destination']); ?>&departure_date=<?php echo urlencode($depDate); ?>&cabin=<?php echo urlencode($flight['cabin']); ?>&passengers=<?php echo $passengers; ?>">
                                    View this date
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

