<?php
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
    die("Error: Could not connect to the database. " . htmlspecialchars($e->getMessage()));
}

// Fetch services
try {
    $servicesQuery = $pdo->prepare("SELECT * FROM services");
    $servicesQuery->execute();
    $services = $servicesQuery->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching services: " . htmlspecialchars($e->getMessage()));
}

// Handle the form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) {
        $message = "Error: All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Error: Invalid email address.";
    } elseif (!preg_match('/^\d{10,15}$/', $phone)) {
        $message = "Error: Phone number must be 10-15 digits.";
    } else {
        try {
            // Insert the data into the database
            $stmt = $pdo->prepare("INSERT INTO appointments (name, email, phone, date, time) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $date, $time]);
            $message = "Your appointment was successfully booked!";
        } catch (PDOException $e) {
            $message = "Error booking appointment: " . htmlspecialchars($e->getMessage());
        }
    }
}

// Fetch all appointments
try {
    $appointmentsQuery = $pdo->prepare("SELECT * FROM appointments ORDER BY date, time");
    $appointmentsQuery->execute();
    $appointments = $appointmentsQuery->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching appointments: " . htmlspecialchars($e->getMessage()));
}
?>
