<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>Aubrey's Insight Full Therapy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- header section starts -->
<header class="header">
    <a href="#" class="logo">
        <img src="img/logo.png" alt="">
    </a>
    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#Services">Services</a>
        <a href="#Others">Other</a>
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

<!-- Services section -->
<section class="menu" id="Services">
    <h1 class="heading"> Our <span>Services</span> </h1>
    <div class="box-container">
        <div class="box">
            <img src="img/Half.png" alt="" width="100%">
            <h3>Half Body Massage</h3>
            <div class="price">₱800.00</div>
            <button class="service-btn" data-service="Half Body Massage">Avail</button>
        </div>
        <div class="box">
            <img src="img/Full.jpg" alt="" width="105%">
            <h3>Full Body Massage</h3>
            <div class="price">₱1200.00</div>
            <button class="service-btn" data-service="Full Body Massage">Avail</button>
        </div>
        <div class="box">
            <img src="img/VIP.jpg" alt="" width="100%">
            <h3>VIP Massage</h3>
            <div class="price">₱1800.00</div>
            <button class="service-btn" data-service="VIP Massage">Avail</button>
        </div>
    </div>
</section>

<!-- Contact section -->
<section class="contact" id="contact">
    <h1 class="heading"> <span>contact</span> us </h1>
    <div class="row">
        <div class="calendar">
            <div class="calendar-header">
                <button id="prev-month">❮</button>
                <div id="month-year"></div>
                <button id="next-month">❯</button>
            </div>
            <div class="calendar-body">
                <div class="calendar-weekdays">
                    <div>Mo</div>
                    <div>Tu</div>
                    <div>We</div>
                    <div>Th</div>
                    <div>Fr</div>
                    <div>Sa</div>
                    <div>Su</div>
                </div>
                <div class="calendar-dates" id="dates"></div>
            </div>
        </div>

        <form id="booking-form">
            <h3>Set Schedule</h3>
            <div class="inputBox">
                <span class="fas fa-user"></span>
                <input type="text" id="name" placeholder="name" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-envelope"></span>
                <input type="email" id="email" placeholder="email" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-phone"></span>
                <input type="number" id="phone" placeholder="number" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-calendar"></span>
                <input type="date" id="appointment-date" placeholder="Select a date" required readonly>
            </div>
            <div class="inputBox">
                <span class="fas fa-cogs"></span>
                <input type="text" id="service-field" placeholder="Selected Service" readonly required>
            </div>
            <input type="submit" value="Book Now" class="btn">
        </form>
    </div>
</section>

<!-- Footer section -->
<section class="footer">
    <div class="links">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#Services">Services</a>
        <a href="#Others">Others</a>
        <a href="#contact">contact</a>
    </div>
    <div class="credit">created by <span>KyDev</span> | all rights reserved</div>
</section>

<script src="js/script.js"></script>
</body>
</html>
