<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $date = htmlspecialchars(trim($_POST['date']));

    // Validate email and phone number format (basic validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        die("Invalid phone number format.");
    }

    // Check if the date is valid
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
        die("Invalid date format. Please use YYYY-MM-DD.");
    }

    // Database connection
    $host = '127.0.0.1';
    $socket = '/data/data/com.termux/files/usr/var/run/mysqld.sock';
    $db = 'booking_system';
    $user = 'root';
    $password = 'larkaholic';

    try {
        $pdo = new PDO("mysql:unix_socket=$socket;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: Could not connect to the database. " . $e->getMessage());
    }

    // Insert booking
    $stmt = $pdo->prepare("INSERT INTO appointments (user_name, email, phone, appointment_date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $phone, $date])) {
        echo "Booking successful! We will contact you shortly.";
    } else {
        echo "Booking failed. Please try again.";
    }
}
?>
