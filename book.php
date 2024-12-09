<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $date = htmlspecialchars($_POST['date']);

    // database connection
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

    // insert booking
    $stmt = $pdo->prepare("INSERT INTO appointments (user_name, email, phone, appointment_date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $phone, $date])) {
        echo "Booking successful! We will contact you shortly.";
    } else {
        echo "Booking failed. Please try again.";
    }
}
?>
