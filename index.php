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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $date = $_POST['date'] ?? null;
    $time = $_POST['time'] ?? null;

    if ($name && $email && $phone && $date && $time) {
        $stmt = $pdo->prepare("INSERT INTO appointments (name, email, phone, date, time) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $date, $time]);
        $message = "Booking confirmed.";
        $showModal = true; // Flag to trigger modal
    } else {
        $message = "Error: Missing required fields.";
        $showModal = false;
    }
}

// Fetch all appointments
$appointmentsQuery = $pdo->query("SELECT * FROM appointments");
$appointments = $appointmentsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .modal.active {
            display: block;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }
        .overlay.active {
            display: block;
        }
        .modal table {
            width: 100%;
            border-collapse: collapse;
        }
        .modal table th, .modal table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .modal table th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Booking Form -->
<form action="book.php" method="POST">
    <h3>Book an Appointment</h3>
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <input type="tel" name="phone" placeholder="Your Phone" required>
    <input type="date" name="date" required>
    <input type="time" name="time" required>
    <button type="submit" class="btn">Book Now</button>
</form>

<!-- Pop-Up Modal -->
<div class="overlay <?= $showModal ? 'active' : '' ?>"></div>
<div class="modal <?= $showModal ? 'active' : '' ?>" id="appointmentsModal">
    <h2>Scheduled Appointments</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?= htmlspecialchars($appointment['name']) ?></td>
                    <td><?= htmlspecialchars($appointment['email']) ?></td>
                    <td><?= htmlspecialchars($appointment['phone']) ?></td>
                    <td><?= htmlspecialchars($appointment['date']) ?></td>
                    <td><?= htmlspecialchars($appointment['time']) ?></td>
                    <td><button class="btn details-btn" data-name="<?= htmlspecialchars($appointment['name']) ?>" data-email="<?= htmlspecialchars($appointment['email']) ?>" data-phone="<?= htmlspecialchars($appointment['phone']) ?>" data-date="<?= htmlspecialchars($appointment['date']) ?>" data-time="<?= htmlspecialchars($appointment['time']) ?>">Details</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn close-modal">Close</button>
</div>

<!-- Appointment Details Modal -->
<div class="overlay" id="detailsOverlay"></div>
<div class="modal" id="detailsModal">
    <h2>Appointment Details</h2>
    <p><strong>Name:</strong> <span id="detailsName"></span></p>
    <p><strong>Email:</strong> <span id="detailsEmail"></span></p>
    <p><strong>Phone:</strong> <span id="detailsPhone"></span></p>
    <p><strong>Date:</strong> <span id="detailsDate"></span></p>
    <p><strong>Time:</strong> <span id="detailsTime"></span></p>
    <button class="btn close-details">Close</button>
</div>

<script>
    // Modal functionality
    const modal = document.getElementById('appointmentsModal');
    const overlay = document.querySelector('.overlay');
    const closeModal = document.querySelector('.close-modal');
    const detailsModal = document.getElementById('detailsModal');
    const detailsOverlay = document.getElementById('detailsOverlay');
    const closeDetails = document.querySelector('.close-details');

    closeModal.addEventListener('click', () => {
        modal.classList.remove('active');
        overlay.classList.remove('active');
    });

    document.querySelectorAll('.details-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('detailsName').textContent = btn.dataset.name;
            document.getElementById('detailsEmail').textContent = btn.dataset.email;
            document.getElementById('detailsPhone').textContent = btn.dataset.phone;
            document.getElementById('detailsDate').textContent = btn.dataset.date;
            document.getElementById('detailsTime').textContent = btn.dataset.time;
            detailsModal.classList.add('active');
            detailsOverlay.classList.add('active');
        });
    });

    closeDetails.addEventListener('click', () => {
        detailsModal.classList.remove('active');
        detailsOverlay.classList.remove('active');
    });
</script>

</body>
</html>
