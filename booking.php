<?php
$page_title = 'Complete Booking | Kisubi Airlines';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/partials/header.php';

function generate_booking_ref(int $length = 6): string {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $ref = '';
    for ($i = 0; $i < $length; $i++) {
        $ref .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $ref;
}

$flight_id = isset($_GET['flight_id']) ? (int)$_GET['flight_id'] : 0;
$passengers = isset($_GET['passengers']) ? (int)$_GET['passengers'] : 1;

$stmt = $pdo->prepare("SELECT * FROM flights WHERE id = :id");
$stmt->execute([':id' => $flight_id]);
$flight = $stmt->fetch();

$error = '';
$success = '';
$booking_ref = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $flight) {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $customer_email = trim($_POST['customer_email'] ?? '');
    $passengers = (int)($_POST['passengers'] ?? 1);

    if (!$customer_name || !$customer_email) {
        $error = 'Please fill in all required fields.';
    } elseif ($passengers < 1 || $passengers > (int)$flight['available_seats']) {
        $error = 'Invalid number of passengers for this flight.';
    } else {
        $pdo->beginTransaction();
        try {
            $total_price = $flight['base_price'] * $passengers;
            $booking_ref = generate_booking_ref();

            $insert = $pdo->prepare(
                "INSERT INTO bookings (booking_ref, user_id, flight_id, customer_name, customer_email, passengers_count, total_price, status)
                 VALUES (:ref, NULL, :flight, :name, :email, :pax, :price, 'Confirmed')"
            );
            $insert->execute([
                ':ref' => $booking_ref,
                ':flight' => $flight['id'],
                ':name' => $customer_name,
                ':email' => $customer_email,
                ':pax' => $passengers,
                ':price' => $total_price,
            ]);

            $update = $pdo->prepare(
                "UPDATE flights SET available_seats = available_seats - :pax WHERE id = :id AND available_seats >= :pax"
            );
            $update->execute([
                ':pax' => $passengers,
                ':id' => $flight['id'],
            ]);

            if ($update->rowCount() === 0) {
                $pdo->rollBack();
                $error = 'Seats are no longer available. Please search again.';
            } else {
                $pdo->commit();
                $success = 'Your booking is confirmed!';
            }
        } catch (Throwable $e) {
            $pdo->rollBack();
            $error = 'An error occurred while processing your booking.';
        }
    }
}
?>

<main class="section">
    <?php if (!$flight): ?>
        <p>Flight not found. Please go back and search again.</p>
    <?php else: ?>
        <h1 class="section-title">Review and confirm your trip</h1>

        <div class="glass-panel" style="padding:16px 18px; margin-bottom:20px;">
            <div style="font-size:0.9rem; color:#9ca3af;">
                Flight <?php echo htmlspecialchars($flight['flight_number']); ?>
                &middot; <?php echo htmlspecialchars($flight['cabin']); ?>
            </div>
            <div style="font-size:1rem; margin-top:4px;">
                <?php echo htmlspecialchars($flight['origin']); ?> &rarr;
                <?php echo htmlspecialchars($flight['destination']); ?>
            </div>
            <div style="font-size:0.8rem; color:#9ca3af; margin-top:4px;">
                Departs: <?php echo htmlspecialchars($flight['departure_time']); ?>
                &middot;
                Arrives: <?php echo htmlspecialchars($flight['arrival_time']); ?>
            </div>
            <div style="font-size:0.9rem; margin-top:8px;">
                Base fare: UGX <?php echo number_format($flight['base_price']); ?> per passenger
            </div>
        </div>

        <?php if ($error): ?>
            <div style="margin-bottom:14px; color:#fca5a5;"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="glass-panel" style="padding:18px; margin-bottom:20px; border-color:rgba(34,197,94,0.7);">
                <h2 style="margin-top:0; margin-bottom:6px;">Booking confirmed</h2>
                <p style="margin:0 0 8px;">Thank you for choosing Kisubi Airlines.</p>
                <p style="margin:0 0 8px;">
                    <strong>Your booking reference:</strong>
                    <span style="font-family:monospace; font-size:1.1rem;">
                        <?php echo htmlspecialchars($booking_ref); ?>
                    </span>
                </p>
                <p style="margin:0 0 4px; font-size:0.9rem; color:#9ca3af;">
                    We have reserved <?php echo $passengers; ?> seat(s). Present this reference and your ID at check-in.
                </p>
                <a class="btn-secondary" href="my_bookings.php" style="margin-top:10px; display:inline-block;">
                    View my booking
                </a>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
            <form method="post" class="glass-panel" style="padding:18px; max-width:480px;">
                <div style="margin-bottom:12px;">
                    <label class="form-label" for="customer_name">Full name</label>
                    <input class="form-input" type="text" id="customer_name" name="customer_name" required>
                </div>
                <div style="margin-bottom:12px;">
                    <label class="form-label" for="customer_email">Email</label>
                    <input class="form-input" type="email" id="customer_email" name="customer_email" required>
                </div>
                <div style="margin-bottom:12px;">
                    <label class="form-label" for="passengers">Passengers</label>
                    <input class="form-input" type="number" id="passengers" name="passengers"
                           min="1" max="<?php echo (int)$flight['available_seats']; ?>"
                           value="<?php echo max(1, $passengers); ?>" required>
                </div>
                <button type="submit" class="btn-primary">Confirm booking</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

