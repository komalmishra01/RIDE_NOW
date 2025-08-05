<?php
session_start();
include 'config.php';

// Check login status at the top
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php'; ?> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
/* Services Section */
.services-section {
    padding: 50px 20px;
    text-align: center;
    background: rgb(250, 248, 220);
}

.services-section h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.services-section p {
    font-size: 1.2rem;
    color: #555;
    max-width: 700px;
    margin: auto;
    line-height: 1.5;
}

/* Services Container */
.services-container {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
    margin-top: 30px;
}

/* Service Box */
.service-box {
    width: 260px;
    height: 280px;
    text-align: center;
    border-radius: 15px;
    padding: 15px;
    background: #f8f9fa;
    box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.service-box img {
    width: 140px;
    height: 140px;
    object-fit: contain;
    margin-bottom: 10px;
}

/* Service Name */
.service-box p {
    font-size: 1.3rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

/* Expanded Card */
.expanded {
    width: 280px;
    height: 350px;
    padding: 20px;
    background: white;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
    transform: scale(1.1);
}

/* Service Details */
.service-details {
    display: none;
    font-size: 1rem;
    color: #444;
    margin-top: 10px;
    text-align: center;
    line-height: 1.4;
    max-width: 90%;
}

/* "Book This Ride" Button */
.book-btn {
    margin-top: 12px;
    padding: 10px 15px;
    border: none;
    background: #6c5ce7;
    color: white;
    font-size: 1rem;
    border-radius: 8px;
    cursor: pointer;
    display: none;
    text-decoration: none;
}

.book-btn:hover {
    background: #5a4bcf;
}
</style>

<!-- Services Section -->
<div class="services-section">
    <h2>Our Services</h2>   
    <p>Choose from a range of affordable and convenient ride options designed to fit your needs. Whether you're traveling solo, with family, or looking for a budget-friendly option, we’ve got you covered.</p>

    <div class="services-container">
        <div class="service-box" onclick="expandCard(this)">
            <img src="img/1 bike.webp" alt="Bike Ride">
            <p>Bike</p>
            <div class="service-details">
                <p>Fast and affordable solo rides, perfect for daily commutes.</p>
                <a href="book_cab.php?type=bike" class="book-btn">Book This Ride</a>
            </div>
        </div>
        <div class="service-box" onclick="expandCard(this)">
            <img src="img/2 auto.png" alt="Auto Ride">
            <p>Auto</p>
            <div class="service-details">
                <p>Budget-friendly auto rides for convenient city travel.</p>
                <a href="book_cab.php?type=auto" class="book-btn">Book This Ride</a>
            </div>
        </div>
        <div class="service-box" onclick="expandCard(this)">
            <img src="img/3 auto share.jpg" alt="Auto Share">
            <p>Auto Share</p>
            <div class="service-details">
                <p>Save money and the environment by sharing your ride.</p>
                <a href="book_cab.php?type=auto_share" class="book-btn">Book This Ride</a>
            </div>
        </div>
        <div class="service-box" onclick="expandCard(this)">
            <img src="img/cab premium.jpg" alt="Cab Premium">
            <p>Cab Premium</p>
            <div class="service-details">
                <p>Enjoy a spacious and luxurious ride with premium cabs.</p>
                <a href="book_cab.php?type=premium" class="book-btn">Book This Ride</a>
            </div>
        </div>
    </div>
</div>

<script>
function expandCard(element) {
    // Collapse other cards
    document.querySelectorAll(".service-box").forEach(box => {
        box.classList.remove("expanded");
        box.querySelector(".service-details").style.display = "none";
        box.querySelector(".book-btn").style.display = "none";
    });

    // Expand the clicked card
    element.classList.add("expanded");
    element.querySelector(".service-details").style.display = "block";
    element.querySelector(".book-btn").style.display = "block";
}
</script>

<?php include 'footer.php'; ?> 
