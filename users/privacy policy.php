<?php include 'header.php'; ?>

<style>
    .privacy-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

    .privacy-header {
        text-align: center;
        background: linear-gradient(135deg, #1a1a1a, #333);
        color: white;
        padding: 40px 20px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .privacy-header h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .privacy-content {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .privacy-section {
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .privacy-section:hover {
        background: #f8f9fa;
        transform: translateX(10px);
    }

    .privacy-section h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    .info-box {
        background: #f0f7ff;
        border-left: 4px solid #007bff;
        padding: 20px;
        margin: 20px 0;
        border-radius: 0 10px 10px 0;
    }

    .privacy-list {
        list-style-type: none;
        padding-left: 20px;
    }

    .privacy-list li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 15px;
        color: #555;
        line-height: 1.6;
    }

    .privacy-list li::before {
        content: "→";
        position: absolute;
        left: 0;
        color: #007bff;
    }
</style>

<div class="privacy-container">
    <div class="privacy-header">
        <h1>Privacy Policy</h1>
        <p>Your privacy matters to us</p>
    </div>

    <div class="privacy-content">
        <div class="privacy-section">
            <h2>Information We Collect</h2>
            <div class="info-box">
                <p>We collect information to provide better services to our users.</p>
            </div>
            <ul class="privacy-list">
                <li>Personal identification information (Name, email, phone number)</li>
                <li>Location data during rides</li>
                <li>Payment information</li>
                <li>Device information and usage data</li>
            </ul>
        </div>

        <div class="privacy-section">
            <h2>How We Use Your Information</h2>
            <ul class="privacy-list">
                <li>To provide and improve our ride-sharing services</li>
                <li>To process your payments</li>
                <li>To communicate with you about your rides</li>
                <li>To ensure safety and security</li>
            </ul>
        </div>

        <div class="privacy-section">
            <h2>Data Protection</h2>
            <div class="info-box">
                <p>We implement various security measures to maintain the safety of your personal information.</p>
            </div>
            <ul class="privacy-list">
                <li>Encryption of sensitive data</li>
                <li>Regular security audits</li>
                <li>Secure data storage</li>
                <li>Limited access to personal information</li>
            </ul>
        </div>

        <div class="privacy-section">
            <h2>Your Rights</h2>
            <ul class="privacy-list">
                <li>Access your personal data</li>
                <li>Request data correction</li>
                <li>Delete your account</li>
                <li>Opt-out of marketing communications</li>
            </ul>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>