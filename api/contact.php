<?php
declare(strict_types=1);

require __DIR__ . '/../src/Env.php';
require __DIR__ . '/../src/Mailer.php';

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function respond(int $status, bool $ok, string $message, array $extra = []): never
{
    http_response_code($status);
    echo json_encode(['ok' => $ok, 'message' => $message] + $extra, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(405, false, 'Method not allowed.');
}

$token = $_POST['csrf'] ?? '';
if (!is_string($token) || !isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
    respond(403, false, 'Your session expired. Please refresh the page and try again.');
}

// Honeypot: real visitors leave this empty.
if (!empty($_POST['website'])) {
    respond(200, true, 'Thank you! Your message has been sent.');
}

// Rate limit: 1 message per 30s, 5 per hour per session.
$now = time();
$_SESSION['sent'] = array_values(array_filter($_SESSION['sent'] ?? [], fn($t) => $now - $t < 3600));
if (count($_SESSION['sent']) >= 5 || (end($_SESSION['sent']) !== false && $now - end($_SESSION['sent']) < 30)) {
    respond(429, false, 'Please wait a moment before sending another message.');
}

$name    = trim((string)($_POST['name'] ?? ''));
$email   = trim((string)($_POST['email'] ?? ''));
$subject = trim((string)($_POST['subject'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

$errors = [];
if ($name === '' || mb_strlen($name) > 100) {
    $errors['name'] = 'Please enter your name.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 160) {
    $errors['email'] = 'Please enter a valid email address.';
}
if (mb_strlen($subject) > 150) {
    $errors['subject'] = 'Subject is too long.';
}
if (mb_strlen($message) < 10 || mb_strlen($message) > 5000) {
    $errors['message'] = 'Message must be between 10 and 5000 characters.';
}
if ($errors) {
    respond(422, false, 'Please correct the highlighted fields.', ['errors' => $errors]);
}

// Strip CR/LF to prevent header injection.
$clean = fn(string $s): string => trim(preg_replace('/[\r\n]+/', ' ', $s));
$name = $clean($name);
$subject = $clean($subject) ?: 'New inquiry';

Env::load(__DIR__ . '/../.env');
$to = array_filter(array_map('trim', explode(',', Env::get('MAIL_TO'))));

$body = "New message from maylyncabillanes.com\n\n"
    . "Name: $name\nEmail: $email\nSubject: $subject\n\n"
    . "$message\n\n---\nIP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\nSent: " . date('Y-m-d H:i:s T') . "\n";

try {
    $mailer = new Mailer(Env::get('SMTP_HOST'), (int)Env::get('SMTP_PORT', '587'), Env::get('SMTP_USER'), Env::get('SMTP_PASS'));
    $mailer->send(
        Env::get('MAIL_FROM'),
        Env::get('MAIL_FROM_NAME', 'Website'),
        $to,
        $email,
        $name,
        "[Portfolio] $subject",
        $body
    );
} catch (Throwable $e) {
    error_log('[contact] ' . $e->getMessage());
    respond(500, false, 'Sorry, your message could not be sent. Please email me directly.');
}

$_SESSION['sent'][] = $now;
respond(200, true, 'Thank you! Your message has been sent.');
