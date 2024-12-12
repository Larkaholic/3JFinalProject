<?php
require_once 'config.php'; // Include your database configuration file

// Fetch existing appointments
$stmt = $pdo->prepare("SELECT * FROM appointments ORDER BY date, time");
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $date = $_POST['date'] ?? null;
    $time = $_POST['time'] ?? null;

    // Validate inputs
    if ($name && $email && $phone && $date && $time) {
        $stmt = $pdo->prepare("INSERT INTO appointments (name, email, phone, date, time) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $date, $time]);

        // Refresh to show updated data and open the modal
        header("Location: " . $_SERVER['PHP_SELF'] . "?showModal=true");
        exit();
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Book an Appointment</h1>
        
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <button type="submit">Book Now</button>
        </form>
    </div>

    <!-- Modal Popup -->
    <div id="appointmentsModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3>Scheduled Appointments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("appointmentsModal");
            const closeBtn = document.querySelector(".close-btn");

            // Show modal if query parameter is present
            if (window.location.search.includes("showModal=true")) {
                modal.style.display = "block";
            }

            // Close modal when clicking the close button
            closeBtn.addEventListener("click", () => {
                modal.style.display = "none";
            });

            // Close modal when clicking outside the modal content
            window.addEventListener("click", (event) => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
