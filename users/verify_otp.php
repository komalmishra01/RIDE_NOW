<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .otp-container {
            max-width: 400px;
            width: 100%;
            padding: 40px 20px;
            text-align: center;
        }

        .otp-icon-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 30px;
        }

        .otp-circle {
            width: 120px;
            height: 120px;
            background: #E3F2FD;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .otp-file {
            width: 60px;
            height: 60px;
            background: #2196F3;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .floating-element {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot1 { background: #4CAF50; top: 0; left: 45%; }
        .dot2 { background: #FF9800; top: 30%; right: 0; }
        .dot3 { background: #E91E63; bottom: 30%; right: 0; }
        .dot4 { background: #9C27B0; bottom: 0; left: 45%; }
        .dot5 { background: #00BCD4; bottom: 30%; left: 0; }
        .dot6 { background: #3F51B5; top: 30%; left: 0; }

        .square1 { background: #FF5252; width: 8px; height: 8px; top: 20%; right: 20%; transform: rotate(45deg); border-radius: 2px; }
        .square2 { background: #7C4DFF; width: 8px; height: 8px; bottom: 20%; left: 20%; transform: rotate(45deg); border-radius: 2px; }

        h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
        }

        .otp-field {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .otp-field input {
            width: 40px;
            height: 40px;
            border: none;
            border-bottom: 2px solid #ddd;
            text-align: center;
            font-size: 20px;
            transition: all 0.3s;
        }

        .otp-field input:focus {
            border-bottom-color: #2196F3;
            outline: none;
        }

        .submit-btn {
            width: 100%;
            max-width: 300px;
            padding: 15px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-btn:hover {
            background: #1976D2;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <div class="otp-icon-wrapper">
        <div class="otp-circle"></div>
        <div class="otp-file">OTP</div>
        <div class="floating-element dot1"></div>
        <div class="floating-element dot2"></div>
        <div class="floating-element dot3"></div>
        <div class="floating-element dot4"></div>
        <div class="floating-element dot5"></div>
        <div class="floating-element dot6"></div>
        <div class="floating-element square1"></div>
        <div class="floating-element square2"></div>
    </div>

    <h2>Verification Code</h2>
    <p>We have sent a verification code to your email</p>

    <form action="reset_password.php" method="POST" id="otpForm">
        <div class="otp-field">
            <input type="text" maxlength="1" oninput="moveToNext(this, 1)">
            <input type="text" maxlength="1" oninput="moveToNext(this, 2)">
            <input type="text" maxlength="1" oninput="moveToNext(this, 3)">
            <input type="text" maxlength="1" oninput="moveToNext(this, 4)">
            <input type="text" maxlength="1" oninput="moveToNext(this, 5)">
            <input type="text" maxlength="1" oninput="moveToNext(this, 6)">
        </div>
        <input type="hidden" name="otp" id="finalOtp">
        <button type="submit" class="submit-btn">Submit</button>
    </form>
</div>

<script>
function moveToNext(input, index) {
    if (input.value.length > 1) input.value = input.value.slice(0, 1);

    const inputs = document.querySelectorAll('.otp-field input');
    if (input.value && index < inputs.length) {
        inputs[index].focus();
    }

    updateHiddenOtp();
}

function updateHiddenOtp() {
    const inputs = document.querySelectorAll('.otp-field input');
    let otp = '';
    inputs.forEach(input => otp += input.value);
    document.getElementById('finalOtp').value = otp;
}

document.querySelectorAll('.otp-field input').forEach((input, idx, inputs) => {
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && idx > 0) {
            inputs[idx - 1].focus();
        }
    });
});
</script>

</body>
</html>
