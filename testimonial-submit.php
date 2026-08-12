<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('testimonials.html');

$name = trim((string)($_POST['name'] ?? ''));
$role = trim((string)($_POST['role'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if ($name === '' || $message === '') {
    http_response_code(422);
    exit('Name and testimonial are required.');
}

$stmt = db()->prepare('INSERT INTO testimonials (name,role,message,status) VALUES (?,?,?,?)');
$stmt->execute([$name,$role,$message,'pending']);

redirect('testimonials.html?submitted=1');
