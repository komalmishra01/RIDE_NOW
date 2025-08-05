<?php include 'header.php'; ?>

<style>
    .terms-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

    .terms-header {
        text-align: center;
        background: linear-gradient(135deg, #1a1a1a, #333);
        color: white;
        padding: 40px 20px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .terms-header h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .terms-content {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .terms-section {
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .terms-section:hover {
        background: #f8f9fa;
        transform: translateX(10px);
    }

    .terms-section h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    .terms-section h3 {
        color: #333;
        font-size: 1.3rem;
        margin: 20px 0 10px;
    }

    .terms-section p, .terms-section li {
        color: #555;
        line-height: 1.8;
        margin-bottom: 15px;
    }

    .terms-section ul {
        list-style-type: none;
        padding-left: 20px;
    }

    .terms-section ul li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 10px;
    }

    .terms-section ul li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #1a1a1a;
    }

    .highlight-box {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 20px;
        margin: 20px 0;
        border-radius: 0 10px 10px 0;
    }

    @media (max-width: 768px) {
        .terms-container {
            margin: 30px auto;
        }
        .terms-header h1 {
            font-size: 2rem;
        }
        .terms-content {
            padding: 20px;
        }
    }
</style>

<div class="terms-container">
    <div class="terms-header">
        <h1>Terms and Conditions</h1>
        <p>Please read these terms carefully before using our services</p>
    </div>

    <div class="terms-content">
        <div class="terms-section">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing and using RideNow's services, you agree to be bound by these Terms and Conditions.</p>
            <div class="highlight-box">
                <p>These terms constitute a legally binding agreement between you and RideNow.</p>
            </div>
        </div>

        <div class="terms-section">
            <h2>2. Service Usage</h2>
            <h3>2.1 Eligibility</h3>
            <ul>
                <li>You must be at least 18 years old</li>
                <li>You must provide valid identification</li>
                <li>You must have a valid payment method</li>
            </ul>

            <h3>2.2 Account Responsibility</h3>
            <p>You are responsible for maintaining the confidentiality of your account information.</p>
        </div>

        <div class="terms-section">
            <h2>3. Booking and Cancellation</h2>
            <ul>
                <li>All bookings are subject to driver availability</li>
                <li>Cancellation fees may apply for late cancellations</li>
                <li>RideNow reserves the right to refuse service</li>
            </ul>
        </div>

        <div class="terms-section">
            <h2>4. Payment Terms</h2>
            <p>By using our services, you agree to pay all fees and charges associated with your rides.</p>
            <ul>
                <li>Fares are calculated based on distance and time</li>
                <li>Additional charges may apply during peak hours</li>
                <li>Payment is processed automatically after each ride</li>
            </ul>
        </div>

        <div class="terms-section">
            <h2>5. User Conduct</h2>
            <div class="highlight-box">
                <p>Users must maintain appropriate behavior during rides and treat drivers with respect.</p>
            </div>
            <ul>
                <li>No illegal activities or substances</li>
                <li>No harassment or discrimination</li>
                <li>No damage to vehicle property</li>
            </ul>
        </div>

        
    </div>
</div>

<?php include 'footer.php'; ?>