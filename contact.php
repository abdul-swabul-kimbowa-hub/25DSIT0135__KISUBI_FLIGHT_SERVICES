<?php
$page_title = 'Contact Kisubi Airlines';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/partials/header.php';

$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$subject || !$message) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO contact_messages (name, email, subject, message)
             VALUES (:n, :e, :s, :m)"
        );
        $stmt->execute([
            ':n' => $name,
            ':e' => $email,
            ':s' => $subject,
            ':m' => $message,
        ]);
        $sent = true;
    }
}
?>

<main class="section">
    <h1 class="section-title">Contact us</h1>

    <div style="display:grid; grid-template-columns:minmax(0,2fr) minmax(0,1.2fr); gap:20px; align-items:flex-start; flex-wrap:wrap;">
        <form method="post" class="glass-panel" style="padding:18px;">
            <?php if ($error): ?>
                <div style="margin-bottom:10px; color:#fca5a5;"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($sent): ?>
                <div style="margin-bottom:10px; color:#bbf7d0;">Message sent. We will get back to you.</div>
            <?php endif; ?>

            <div style="margin-bottom:12px;">
                <label class="form-label" for="name">Name</label>
                <input class="form-input" type="text" id="name" name="name" required>
            </div>
            <div style="margin-bottom:12px;">
                <label class="form-label" for="email">Email</label>
                <input class="form-input" type="email" id="email" name="email" required>
            </div>
            <div style="margin-bottom:12px;">
                <label class="form-label" for="subject">Subject</label>
                <input class="form-input" type="text" id="subject" name="subject" required>
            </div>
            <div style="margin-bottom:12px;">
                <label class="form-label" for="message">Message</label>
                <textarea class="form-input" id="message" name="message" rows="4" style="resize:vertical;" required></textarea>
            </div>
            <button type="submit" class="btn-primary">Send message</button>
        </form>

        <div class="glass-panel" style="padding:18px;">
            <h2 style="margin-top:0; font-size:1rem;">Head office</h2>
            <p style="font-size:0.9rem; color:#9ca3af;">
                Kisubi Airlines<br>
                Entebbe International Airport<br>
                Kampala – Entebbe Highway, Uganda
            </p>
            <p style="font-size:0.9rem; color:#9ca3af;">
                Phone: +256 000 000000<br>
                Email: support@kisubiairlines.test
            </p>
            <p style="font-size:0.8rem; color:#6b7280;">
                This is a demo project and not an actual airline. Do not use for real travel planning.
            </p>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>

