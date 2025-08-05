<?php 
session_start(); // Start the session
include 'header.php'; 
?>

<!-- Step 1: Check if Session is Working -->
<?php
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red; text-align: center;'>Session not set. Please login.</p>";
} else {
    echo "<p style='color: green; text-align: center;'>Welcome, User ID: " . $_SESSION['user_id'] . "</p>";
}
?>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: 250, 248, 220;
    }

    .main-banner {
        position: relative;
        height: 55vh;
        background: url('img/raval.jpg') center/cover no-repeat;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: white;
    }

    .main-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .banner-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding-top: 150px;
    }

    .banner-content h1 {
        font-size: 3.5rem;
        margin-bottom: -20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .banner-content p {
        font-size: 1.8rem;
        margin-bottom: 25px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    .search-container {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(8px);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        width: 90%;
        max-width: 1200px;
        margin-top: 40px;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .search-form {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-input {
        flex: 1;
        position: relative;
    }

    .search-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #00AFF5;
    }

    .search-input input,
    .search-input select {
        width: 100%;
        padding: 10px 12px 10px 40px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        outline: none;
    }

    .search-btn {
        background: #00AFF5;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #0095da;
        transform: translateY(-2px);
    }

    /* Features Grid */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        padding: 50px 10%;
        background: #f8f9fa;
    }

    .feature-item {
        text-align: center;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .feature-item:hover {
        transform: translateY(-10px);
    }

    /* New Section CSS */
    .ride-info {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        margin: 50px auto;
        max-width: 80%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .ride-info-text {
        flex: 1;
        padding-right: 30px;
    }

    .ride-info h2 {
        color: #002b5c;
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .ride-info p {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .ride-info img {
        max-width: 300px;
        border-radius: 10px;
    }

    .offer-ride-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background: #00AFF5;
        color: white;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: bold;
        text-decoration: none;
        transition: background 0.3s;
    }

    .offer-ride-btn:hover {
        background: #008ac7;
    }

    @media (max-width: 768px) {
        .ride-info {
            flex-direction: column;
            text-align: center;
        }

        .ride-info-text {
            padding-right: 0;
            margin-bottom: 20px;
        }

        .ride-info img {
            max-width: 250px;
        }
    }
        /* Hover Effects */
    .search-btn:hover {
        background: #0095da;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .search-input input:hover,
    .search-input select:hover {
        border-color: #00AFF5;
        box-shadow: 0px 2px 8px rgba(0, 175, 245, 0.5);
    }
    .feature-icon {
        font-size: 3.5rem; /* Increased from 2.5rem */
        color: #00AFF5; /* Already blue, but making sure it's consistent */
        margin-bottom: 20px;
        transition: all 0.3s ease; /* Added smooth transition */
    }

    /* Optional: Add hover effect for icons */
    .feature-icon i:hover {
        transform: scale(1.1);
        color: #0095da;
    }
    .feature-item:hover {
        transform: translateY(-10px) rotate(1deg);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .ride-info:hover {
        transform: scale(1.02);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .offer-ride-btn:hover {
        background: #008ac7;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 5px 15px rgba(0, 138, 199, 0.5);
    }

    .banner-content h1:hover {
        color: #00AFF5;
        text-shadow: 3px 3px 6px rgba(0, 175, 245, 0.3);
        transition: color 0.3s ease-in-out;
    }

    .banner-content p:hover {
        color: #f1f1f1;
        text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.3);
    }
    .search-input select {
    width: 100%;
    padding: 10px 12px 10px 40px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    background: white;
    cursor: pointer;
}

.search-input select:hover {
    border-color: #00AFF5;
    box-shadow: 0px 2px 8px rgba(0, 175, 245, 0.5);
}

</style>

<div class="main-banner">
    <div class="banner-content">
        <h1>Welcome to RideNow</h1>
        <p>"Your Next Ride is Just One Click Away – RideNow!"</p>
    </div>
    <div class="search-container">
      <form class="search-form" action="book_cab.php" method="GET">
        <div class="search-input">
            <i class="fas fa-map-marker-alt"></i>
            <select id="pickup" name="pickup_location" required>
                <option value="">Select Pickup Location</option>
                <option value="Ahmedabad Airport">Ahmedabad Airport</option>
                <option value="Ahmedabad Railway Station">Ahmedabad Railway Station</option>
                <option value="Iscon Mall Ahmedabad">Iscon Mall</option>
                <option value="Alpha One Mall Ahmedabad">Alpha One Mall</option>
                <option value="Sabarmati Ashram Ahmedabad">Sabarmati Ashram</option>
                <option value="Gujarat University Ahmedabad">Gujarat University</option>
                <option value="Maninagar Ahmedabad">Maninagar</option>
                <option value="Vastrapur Lake Ahmedabad">Vastrapur Lake</option>
            </select>
        </div>
        <div class="search-input">
            <i class="fas fa-location-arrow"></i>
            <select id="drop" name="drop_location" required>
                <option value="">Select Drop Location</option>
                <option value="Ahmedabad Airport">Ahmedabad Airport</option>
                <option value="Ahmedabad Railway Station">Ahmedabad Railway Station</option>
                <option value="Iscon Mall Ahmedabad">Iscon Mall</option>
                <option value="Alpha One Mall Ahmedabad">Alpha One Mall</option>
                <option value="Sabarmati Ashram Ahmedabad">Sabarmati Ashram</option>
                <option value="Gujarat University Ahmedabad">Gujarat University</option>
                <option value="Maninagar Ahmedabad">Maninagar</option>
                <option value="Vastrapur Lake Ahmedabad">Vastrapur Lake</option>
            </select>
        </div>
        <div class="search-input">
            <i class="fas fa-user"></i>
            <select name="passengers" required>
                <option value="1">1 passenger</option>
                <option value="2">2 passengers</option>
                <option value="3">3 passengers</option>
                <option value="4">4 passengers</option>
                </select>
        </div>
        <button type="submit" class="search-btn">Search</button>
      </form>
    </div>
</div>


<div class="features-grid">
    <div class="feature-item">
        <div class="feature-icon">
            <i class="fas fa-tag"></i>
        </div>
        <h3>Your pick of rides at low prices</h3>
        <p>No matter where you're going, find the perfect ride from our wide range of destinations and routes at low prices.</p>
    </div>
    <div class="feature-item">
        <div class="feature-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h3>Trust who you travel with</h3>
        <p>We take the time to get to know each of our members and partners. We check reviews, profiles and IDs, so you know who you're travelling with.</p>
    </div>
    <div class="feature-item">
        <div class="feature-icon">
            <i class="fas fa-bolt"></i>
        </div>
        <h3>Scroll, click, tap and go!</h3>
        <p>Booking a ride has never been easier! Thanks to our simple app powered by great technology, you can book your ride in just minutes.</p>
    </div>
</div>
<!-- New Ride Info Section -->
<div class="ride-info">
    <div class="ride-info-text">
        <h2>Driving in your car soon?</h2>
        <p>Enjoy Every Ride with Ride Now! We ensure a stress-free experience with friendly drivers and happy passengers.</p>
        <a href="#" class="offer-ride-btn">Offer a ride</a>
    </div>
    <img src="img/1..jpg.png" alt="Ride Now">
</div>

<?php include 'footer.php'; ?>
