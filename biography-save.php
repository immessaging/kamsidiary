<?php

declare(strict_types=1);

session_start();

/*
|--------------------------------------------------------------------------
| KAMSI DIARY - BIOGRAPHY SAVE
|--------------------------------------------------------------------------
| Receives the biography form from biography.html
|--------------------------------------------------------------------------
*/


/* ---------------------------------------------------------
   1. ONLY ALLOW POST REQUESTS
--------------------------------------------------------- */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: biography.html');
    exit;
}


/* ---------------------------------------------------------
   2. REQUIRE LOGIN
--------------------------------------------------------- */

if (empty($_SESSION['user_id'])) {

    header('Location: signin.html');
    exit;
}


/* ---------------------------------------------------------
   3. DATABASE CONFIGURATION
--------------------------------------------------------- */

$host = 'localhost';
$dbname = 'kamsi_diary';
$username = 'root';
$password = '';

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

} catch (PDOException $e) {

    http_response_code(500);

    exit('Unable to connect to the diary service.');
}


/* ---------------------------------------------------------
   4. GET LOGGED-IN USER
--------------------------------------------------------- */

$user_id = (int) $_SESSION['user_id'];


/* ---------------------------------------------------------
   5. GET FORM DATA
--------------------------------------------------------- */

$fullname = trim($_POST['fullname'] ?? '');

$dob = trim($_POST['dob'] ?? '');

$occupation = trim($_POST['occupation'] ?? '');

$country = trim($_POST['country'] ?? '');

$childhood = trim($_POST['childhood'] ?? '');

$education = trim($_POST['education'] ?? '');

$career = trim($_POST['career'] ?? '');

$family = trim($_POST['family'] ?? '');

$achievements = trim($_POST['achievements'] ?? '');

$lessons = trim($_POST['lessons'] ?? '');

$quotes = trim($_POST['quotes'] ?? '');

$legacy = trim($_POST['legacy'] ?? '');


/* ---------------------------------------------------------
   6. BASIC VALIDATION
--------------------------------------------------------- */

if ($fullname === '') {

    http_response_code(422);

    exit('Please enter your full name.');
}


if ($dob === '') {

    http_response_code(422);

    exit('Please provide your date of birth.');
}


/* ---------------------------------------------------------
   7. VALIDATE DATE
--------------------------------------------------------- */

$date = DateTime::createFromFormat('Y-m-d', $dob);

if (!$date || $date->format('Y-m-d') !== $dob) {

    http_response_code(422);

    exit('Please provide a valid date of birth.');
}


/* ---------------------------------------------------------
   8. LIMIT INPUT LENGTHS
--------------------------------------------------------- */

if (mb_strlen($fullname) > 150) {

    http_response_code(422);

    exit('Your name is too long.');
}


if (mb_strlen($occupation) > 150) {

    http_response_code(422);

    exit('Occupation is too long.');
}


if (mb_strlen($country) > 100) {

    http_response_code(422);

    exit('Country name is too long.');
}


/* ---------------------------------------------------------
   9. SAVE BIOGRAPHY
--------------------------------------------------------- */

try {

    $sql = "
        INSERT INTO biographies
        (
            user_id,
            fullname,
            date_of_birth,
            occupation,
            country,
            childhood,
            education,
            career,
            family,
            achievements,
            lessons,
            quotes,
            legacy,
            created_at,
            updated_at
        )

        VALUES
        (
            :user_id,
            :fullname,
            :date_of_birth,
            :occupation,
            :country,
            :childhood,
            :education,
            :career,
            :family,
            :achievements,
            :lessons,
            :quotes,
            :legacy,
            NOW(),
            NOW()
        )
    ";

    $statement = $pdo->prepare($sql);

    $statement->execute([

        ':user_id' => $user_id,

        ':fullname' => $fullname,

        ':date_of_birth' => $dob,

        ':occupation' => $occupation,

        ':country' => $country,

        ':childhood' => $childhood,

        ':education' => $education,

        ':career' => $career,

        ':family' => $family,

        ':achievements' => $achievements,

        ':lessons' => $lessons,

        ':quotes' => $quotes,

        ':legacy' => $legacy

    ]);

} catch (PDOException $e) {

    http_response_code(500);

    exit('Your biography could not be saved. Please try again.');
}


/* ---------------------------------------------------------
   10. REFRESH SESSION ID
--------------------------------------------------------- */

session_regenerate_id(true);


/* ---------------------------------------------------------
   11. REDIRECT TO USER DASHBOARD
--------------------------------------------------------- */

header('Location: user-dashboard.php?saved=1');

exit;

?>