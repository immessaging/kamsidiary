<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('signup.html');

$name = trim((string)($_POST['name'] ?? ''));
$email = strtolower(trim((string)($_POST['email'] ?? '')));
$password = (string)($_POST['password'] ?? '');

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
    http_response_code(422);
    exit('Please provide a valid name, email and password of at least 8 characters.');
}

try {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = db()->prepare('INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?,?)');
    $stmt->execute([$name,$email,$hash,'user']);
    redirect('signin.html');
} catch (PDOException $ex) {
    if ((int)$ex->errorInfo[1] === 1062) {
        http_response_code(409);
        exit('An account with that email already exists.');
    }
    http_response_code(500);
    exit('Unable to create the account.');
}
