<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('contact.html');

$name = trim((string)($_POST['name'] ?? ''));
$email = strtolower(trim((string)($_POST['email'] ?? '')));
$subject = trim((string)($_POST['subject'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') {
    http_response_code(422);
    exit('Please complete all required fields.');
}

$stmt = db()->prepare('INSERT INTO contact_messages (name,email,subject,message) VALUES (?,?,?,?)');
$stmt->execute([$name,$email,$subject,$message]);

redirect('contact.html?sent=1');
