<?php include 'header.php'; ?>

<style>
    
    /* Add these new styles after your existing CSS */
    .title-box {
        position: relative;
        display: inline-block;
        padding: 15px 30px;
    }

    .title-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,rgb(241, 241, 241),rgb(222, 241, 255));
        border-radius: 10px;
        z-index: -1;
        transform: skew(-3deg);
        box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
    }

    .about-header h1 {
        font-size: 36px;
        color: white;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .about-container {
        max-width: 1000px;
        margin: 50px auto;
        padding: 20px;
    }

    .about-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .about-header h1 {
        font-size: 36px;
        color: #333;
        margin-bottom: 15px;
    }

    .about-header p {
        font-size: 18px;
        color: #666;
    }

    .about-content {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .section {
        margin-bottom: 30px;
    }

    .section h2 {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    .section p {
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .feature-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .feature-item h3 {
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .feature-item p {
        color: #666;
        font-size: 15px;
    }

    @media (max-width: 768px) {
        .features {
            grid-template-columns: 1fr;
        }
    }

 
    .about-container {
        max-width: 1000px;
        margin: 50px auto;
        padding: 20px;
    }

    .about-header {
        text-align: center;
        margin-bottom: 40px;
        transition: transform 0.3s ease;
    }

    .about-header:hover {
        transform: translateY(-5px);
    }

    .about-header h1 {
        font-size: 36px;
        color: #333;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .about-header:hover h1 {
        color: #007bff;
    }

    .about-content {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .about-content:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .section {
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .section:hover h2 {
        color: #007bff;
        border-bottom-color: #007bff;
    }

    .section h2 {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
        transition: all 0.3s ease;
    }

    .feature-item {
        padding: 15px;
        background:rgb(255, 210, 245);
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .feature-item:hover {
        background: #fff;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
        border-color: #007bff;
    }

    .feature-item:hover h3 {
        color: #007bff;
    }

    .feature-item h3 {
        color: #2c3e50;
        font-size: 18px;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .feature-item p {
        color: #666;
        font-size: 15px;
        transition: color 0.3s ease;
    }

    .feature-item:hover p {
        color: #333;
    }
</style>

<!-- Update this part in your HTML -->
<div class="about-header">
    <div class="title-box">
        <h1>About RideNow</h1>
    </div>
    <p>Your Trusted Ride-Sharing Partner</p>
</div>

<div class="about-container">
    

    <div class="about-content">
        <div class="section">
            <h2>Who We Are</h2>
            <p>RideNow is a leading ride-sharing service committed to providing safe, reliable, and affordable transportation solutions. We connect passengers with verified drivers to ensure comfortable and convenient travel experiences.</p>
        </div>

        <div class="section">
            <h2>Our Mission</h2>
            <p>We strive to revolutionize urban mobility by offering accessible transportation options that make daily commuting easier and more efficient for everyone.</p>
        </div>

        <div class="section">
            <h2>Why Choose Us</h2>
            <div class="features">
                <div class="feature-item">
                    <h3>Safety First</h3>
                    <p>All our drivers are verified and vehicles regularly inspected for your safety.</p>
                </div>
                <div class="feature-item">
                    <h3>Affordable Rates</h3>
                    <p>Competitive pricing with transparent fare calculations.</p>
                </div>
                <div class="feature-item">
                    <h3>24/7 Support</h3>
                    <p>Round-the-clock customer service to assist you anytime.</p>
                </div>
                <div class="feature-item">
                    <h3>Quick Booking</h3>
                    <p>Easy and fast booking process through our mobile app.</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Our Vision</h2>
            <p>We envision a future where transportation is seamless, sustainable, and accessible to all. Through innovation and dedication, we're working to make this vision a reality.</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>