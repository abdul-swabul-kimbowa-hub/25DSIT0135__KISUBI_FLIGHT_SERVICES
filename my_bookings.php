<?php
$page_title = 'My Bookings | Kisubi Airlines';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/partials/header.php';

$booking = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref = strtoupper(trim($_POST['booking_ref'] ?? ''));
    $email = trim($_POST['email'] ?? '');

    if (!$ref || !$email) {
        $error = 'Please enter both booking reference and email.';
    } else {
        $stmt = $pdo->prepare(
            "SELECT b.*, f.flight_number, f.origin, f.destination, f.departure_time, f.arrival_time, f.cabin
             FROM bookings b
             JOIN flights f ON b.flight_id = f.id
             WHERE b.booking_ref = :ref AND b.customer_email = :email"
        );
        $stmt->execute([':ref' => $ref, ':email' => $email]);
        $booking = $stmt->fetch();
        if (!$booking) {
            $error = 'No booking found for that reference and email.';
        }
    }
}
?>

<main class="section">
    <h1 class="section-title">Manage your booking</h1>

    <form method="post" class="glass-panel" style="padding:18px; max-width:460px; margin-bottom:22px;">
        <div style="margin-bottom:12px;">
            <label class="form-label" for="booking_ref">Booking reference</label>
            <input class="form-input" type="text" id="booking_ref" name="booking_ref"
                   placeholder="e.g. ABC123" required>
        </div>
        <div style="margin-bottom:12px;">
            <label class="form-label" for="email">Email used during booking</label>
            <input class="form-input" type="email" id="email" name="email" required>
        </div>
        <button type="submit" class="btn-primary">Find booking</button>
    </form>

    <?php if ($error): ?>
        <div style="margin-bottom:14px; color:#fca5a5;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($booking): ?>
        <div class="glass-panel" style="padding:18px; max-width:640px;">
            <h2 style="margin-top:0;">Booking <?php echo htmlspecialchars($booking['booking_ref']); ?></h2>
            <p style="font-size:0.9rem; color:#9ca3af;">
                Status: <strong><?php echo htmlspecialchars($booking['status']); ?></strong>
                &middot; Created: <?php echo htmlspecialchars($booking['created_at']); ?>
            </p>
            <p>
                <?php echo htmlspecialchars($booking['customer_name']); ?><br>
                <?php echo htmlspecialchars($booking['customer_email']); ?>
            </p>
            <p>
                Flight <?php echo htmlspecialchars($booking['flight_number']); ?>
                (<?php echo htmlspecialchars($booking['cabin']); ?>)<br>
                <?php echo htmlspecialchars($booking['origin']); ?> &rarr;
                <?php echo htmlspecialchars($booking['destination']); ?><br>
                Departs: <?php echo htmlspecialchars($booking['departure_time']); ?><br>
                Arrives: <?php echo htmlspecialchars($booking['arrival_time']); ?>
            </p>
            <p>
                Passengers: <?php echo (int)$booking['passengers_count']; ?><br>
                Total paid: UGX <?php echo number_format($booking['total_price']); ?>
            </p>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

