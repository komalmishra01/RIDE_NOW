<?php include 'header.php'; ?>

<style>
    .gallery-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

        /* Background Doodles */
        .gallery-container::before {
        content: "\f1ba  \f0d1  \f21c  \f5c0";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 90px;
        color: rgba(0, 0, 0, 0.05);
        position: absolute;
        top: 10%;
        left: 10%;
        z-index: -1;
    }

    .gallery-container::after {
        content: "\f0d1  \f1ba  \f21c  \f5c0";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        font-size: 80px;
        color: rgba(0, 0, 0, 0.05);
        position: absolute;
        bottom: 10%;
        right: 10%;
        z-index: -1;
    }

    .gallery-container h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #002147;
    }

    .gallery-container p {
        font-size: 1.1rem;
        color: #444;
        max-width: 700px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }



    .gallery-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .gallery-header h1 {
        font-size: 36px;
        color: #333;
        position: relative;
        display: inline-block;
        padding: 15px 30px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        padding: 20px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(50px);
        opacity: 0;
        animation: slideUp 0.6s forwards;
    }

    .gallery-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        bottom: -100%;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 20px;
        transition: bottom 0.3s ease-in-out;
    }

    .gallery-item:hover .gallery-overlay {
        bottom: 0;
    }

    .gallery-overlay h3 {
        margin: 0 0 10px 0;
        font-size: 20px;
    }

    .gallery-overlay p {
        margin: 0;
        font-size: 14px;
        color: white;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 992px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }
    }

    .gallery-item:nth-child(1) { animation-delay: 0.1s; }
    .gallery-item:nth-child(2) { animation-delay: 0.2s; }
    .gallery-item:nth-child(3) { animation-delay: 0.3s; }
    .gallery-item:nth-child(4) { animation-delay: 0.4s; }
    .gallery-item:nth-child(5) { animation-delay: 0.5s; }
    .gallery-item:nth-child(6) { animation-delay: 0.6s; }
</style>

<div class="container gallery-container">
    <div class="gallery-header">
        <h1>Photo Gallery 🚖</h1>
        <p>
        Explore our journey through these images! From booking a ride to reaching your destination safely, 
        our taxi service ensures a smooth and comfortable travel experience. Check out these snapshots 
        capturing different moments of our service in action.
    </p>
    </div>

    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="img/1img.jpg" alt="Luxury Car">
            <div class="gallery-overlay">
                <h3>Luxury Sedans</h3>
                <p>Experience comfort and style with our premium sedan fleet</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="img/4img.jpg" alt="SUV">
            <div class="gallery-overlay">
                <h3>Spacious SUVs</h3>
                <p>Perfect for family trips and group travel</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="img/7img.jpg" alt="Electric Car">
            <div class="gallery-overlay">
                <h3>Electric Vehicles</h3>
                <p>Eco-friendly transportation options</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="img/6img.jpg" alt="Interior">
            <div class="gallery-overlay">
                <h3>Premium Interiors</h3>
                <p>Luxurious and comfortable cabin space</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="img/8img.jpg" alt="Driver">
            <div class="gallery-overlay">
                <h3>Professional Drivers</h3>
                <p>Experienced and courteous chauffeurs</p>
            </div>
        </div>
        <div class="gallery-item">
            <img src="img/9img.jpg" alt="Service">
            <div class="gallery-overlay">
                <h3>24/7 Service</h3>
                <p>Available round the clock for your convenience</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>