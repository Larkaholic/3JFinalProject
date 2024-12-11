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

$servicesQuery = $pdo->query("SELECT * FROM services");
$services = $servicesQuery->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $date = $_POST['date'] ?? null;

    if (!$name || !$email || !$phone || !$date) {
        die("Error: Missing required fields.");
    }

    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);
    $phone = htmlspecialchars($phone);
    $date = htmlspecialchars($date);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>Aubrey's Insight Full Therapy</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
<!-- header section starts  -->

<header class="header">
    <a href="#" class="logo">
        <img src="img/logo.png" alt="">
    </a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#Services">Services</a>
        <a href="#Others">Others</a>
        <a href="#contact">contact</a>
    </nav>

    <div class="icons">
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>
</header>

<!-- home section -->
<section class="home" id="home">
    <div class="content">
        <h3>Aubrey's Insight Full Therapy</h3>       
    </div>
</section>

<!-- about section -->
<section class="about" id="about">
    <h1 class="heading"> <span>about</span> us </h1>
    <div class="row">
        <div class="image">
            <img src="img/About.jpg" alt="">
        </div>
        <div class="content">
            <h3>Welcome to Aubrey's Insight Full Therapy</h3>
            <p>“Wellness is not a destination, but a journey of self-discovery and healing. Embrace each step with compassion and courage.”</p>
            <a href="#contact" class="btn">Book Now</a>
        </div>
    </div>
</section>

<!-- services section -->
<section class="menu" id="Services">
    <h1 class="heading"> Our <span>Services</span> </h1>
    <div class="box-container">
        <?php foreach ($services as $service): ?>
            <div class="box">
                <img src="img/<?= htmlspecialchars($service['image']) ?>" alt="" width="100%">
                <h3><?= htmlspecialchars($service['name']) ?></h3>
                <div class="price">₱<?= number_format($service['price'], 2) ?>
                    <br>
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fas fa-star<?= $i + 0.5 <= $service['rating'] ? '-half-alt' : '' ?>"></i>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- contact section -->
<section class="contact" id="contact">
    <h1 class="heading"> <span>contact</span> us </h1>

    <div class="row">
        <form action="book.php" method="POST">
            <h3>Set Schedule</h3>
            <div class="inputBox">
                <span class="fas fa-user"></span>
                <input type="text" name="name" placeholder="name" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-envelope"></span>
                <input type="email" name="email" placeholder="email" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-phone"></span>
                <input type="number" name="phone" placeholder="number" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-calendar"></span>
                <input type="date" name="date" placeholder="Select a date" required>
            </div>
            <input type="submit" value="Book Now" class="btn">
        </form>
    </div>
</section>

<!-- footer section -->
<section class="footer">
    <div class="links">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#Services">Services</a>
        <a href="#Others">Others</a>
        <a href="#contact">contact</a>
    </div>
    <p>&copy; 2024 Aubrey's Insight Full Therapy. All Rights Reserved.</p>
</section>

<script src="js/script.js"></script>
</body>
</html>