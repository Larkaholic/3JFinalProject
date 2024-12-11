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
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// Fetch services
$servicesQuery = $pdo->query("SELECT * FROM services");
$services = $servicesQuery->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $date = htmlspecialchars($_POST['date'] ?? '');

    if ($name && $email && $phone && $date) {
        $stmt = $pdo->prepare("INSERT INTO appointments (name, email, phone, date) VALUES (:name, :email, :phone, :date)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':date' => $date,
        ]);
        echo "<p>Appointment booked successfully!</p>";
    } else {
        echo "<p>Error: Missing required fields.</p>";
    }
}

// Fetch appointments
$appointmentsQuery = $pdo->query("SELECT * FROM appointments ORDER BY date ASC");
$appointments = $appointmentsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aubrey's Insight Full Therapy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    

    
    <section id="appointments">
        <h1 class="heading"> <span>Appointments</span> </h1>
        <table border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['id']) ?></td>
                        <td><?= htmlspecialchars($appointment['name']) ?></td>
                        <td><?= htmlspecialchars($appointment['email']) ?></td>
                        <td><?= htmlspecialchars($appointment['phone']) ?></td>
                        <td><?= htmlspecialchars($appointment['date']) ?></td>
                        <td><?= htmlspecialchars($appointment['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

   

</body>
</html>
