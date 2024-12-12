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
        echo "<p>Booking successful! We will contact you shortly.</p>";
    } else {
        die("Booking failed. Please try again.");
    }
}

// Retrieve all appointments
try {
    $appointmentsStmt = $pdo->query("SELECT id, user_name, email, phone, appointment_date FROM appointments ORDER BY appointment_date ASC");
    $appointments = $appointmentsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving appointments: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking System</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Booking System</h1>

    <!-- Booking Form -->
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>

        <button type="submit">Submit</button>
    </form>

    <!-- Appointments Table -->
    <?php if (!empty($appointments)): ?>
        <h2>All Appointments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['id']) ?></td>
                        <td><?= htmlspecialchars($appointment['user_name']) ?></td>
                        <td><?= htmlspecialchars($appointment['email']) ?></td>
                        <td><?= htmlspecialchars($appointment['phone']) ?></td>
                        <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
</body>
</html>
