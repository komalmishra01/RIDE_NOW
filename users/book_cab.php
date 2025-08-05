<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include header after all redirects
include 'header.php';

// Rest of your code...
// Fetch price configuration from database
$sql = "SELECT * FROM admin_vehicle_rates";
$result = $conn->query($sql);
$PRICE_CONFIG = [];
while ($row = $result->fetch_assoc()) {
    $PRICE_CONFIG[$row['vehicle_type']] = [
        'basePrice' => floatval($row['base_price']),
        'perKm' => floatval($row['per_km']),
        'perPassenger' => floatval($row['per_passenger'])
    ];
}

$ride_type = isset($_GET['type']) ? $_GET['type'] : 'car premium';
$priceConfigJson = json_encode($PRICE_CONFIG);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Your Ride - RIDE NOW</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        .wrapper {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 20px;
        }
        .booking-container {
            flex: 0 0 500px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .map-container {
            flex: 1;
            height: 800px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        #map { width: 100%; height: 100%; }
        .form-group { margin-bottom: 20px; }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        .price-info {
            background: #f0f2ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .total-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #6c5ce7;
        }
        .btn-primary {
            background: #6c5ce7;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #5a4bcf;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="booking-container">
        <h2>Book Your Ride</h2>

        <form id="bookingForm" action="save_booking.php" method="POST">
            <div class="form-group">
                <label>Select Vehicle Type</label>
                <select name="ride_type" class="form-control" required>
                    <?php foreach ($PRICE_CONFIG as $type => $config): ?>
                        <option value="<?= $type ?>" <?= ($ride_type === $type) ? 'selected' : '' ?>>
                            <?= ucfirst($type) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="distance" id="hidden_distance" value="0">
            <input type="hidden" name="amount" id="hidden_total_amount" value="0">

            <div class="form-group">
                <label>Pickup Location</label>
                <select id="pickup" name="pickup_location" required class="form-control">
                    <option value="">Select Pickup Location</option>
                    <?php
                    $locations = [
                        "Ahmedabad Airport", "Ahmedabad Railway Station", "Iscon Mall",
                        "Alpha One Mall", "Sabarmati Ashram", "Gujarat University",
                        "Maninagar", "Vastrapur Lake"
                    ];
                    foreach ($locations as $loc) {
                        echo "<option value=\"$loc\">$loc</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Drop Location</label>
                <select id="drop" name="drop_location" required class="form-control">
                    <option value="">Select Drop Location</option>
                    <?php
                    foreach ($locations as $loc) {
                        echo "<option value=\"$loc\">$loc</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" name="booking_date" required class="form-control" min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label>Time</label>
                <input type="time" name="booking_time" required class="form-control">
            </div>

            <div class="form-group">
                <label>Number of Passengers</label>
                <input type="number" name="passengers" required class="form-control" min="1" max="4" value="1">
            </div>

            <div class="price-info">
                <p>Distance: <span id="distance">0 km</span></p>
                <p>Duration: <span id="duration">0 min</span></p>
                <p>Base Price: ₹<span id="basePrice">0</span></p>
                <p>Distance Price: ₹<span id="distancePrice">0</span></p>
                <p>Passenger Price: ₹<span id="passengerPrice">0</span></p>
                <hr>
                <p class="total-price">Total: ₹<span id="totalPrice">0</span></p>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Confirm Booking</button>
        </form>
    </div>

    <div class="map-container">
        <div id="map"></div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
const PRICE_CONFIG = <?php echo $priceConfigJson; ?>;
const LOCATIONS = {
    "Ahmedabad Airport": [23.0735, 72.6346],
    "Ahmedabad Railway Station": [23.0225, 72.5714],
    "Iscon Mall": [23.0301, 72.5108],
    "Alpha One Mall": [23.0467, 72.5311],
    "Sabarmati Ashram": [23.0609, 72.5809],
    "Gujarat University": [23.0365, 72.5461],
    "Maninagar": [22.9959, 72.5986],
    "Vastrapur Lake": [23.0374, 72.5287]
};

let map, routingControl;

function initMap() {
    map = L.map('map').setView([23.0225, 72.5714], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    for (let [name, coords] of Object.entries(LOCATIONS)) {
        L.marker(coords).addTo(map).bindPopup(name);
    }

    document.getElementById('pickup').addEventListener('change', calculateRoute);
    document.getElementById('drop').addEventListener('change', calculateRoute);
}

function calculatePrice(distance, passengers, vehicleType) {
    if (!PRICE_CONFIG[vehicleType]) vehicleType = 'car premium';

    const prices = PRICE_CONFIG[vehicleType];
    const basePrice = prices.basePrice;
    const distancePrice = Math.ceil(distance * prices.perKm);
    const passengerPrice = (passengers - 1) * prices.perPassenger;
    const total = basePrice + distancePrice + passengerPrice;

    document.getElementById('basePrice').textContent = basePrice;
    document.getElementById('distancePrice').textContent = distancePrice;
    document.getElementById('passengerPrice').textContent = passengerPrice;
    document.getElementById('totalPrice').textContent = total;

    document.getElementById('hidden_distance').value = distance.toFixed(2);
    document.getElementById('hidden_total_amount').value = total;
}

function calculateRoute() {
    const pickup = document.getElementById('pickup').value;
    const drop = document.getElementById('drop').value;

    if (!pickup || !drop || pickup === drop) return;

    const start = LOCATIONS[pickup];
    const end = LOCATIONS[drop];

    if (routingControl) map.removeControl(routingControl);

    routingControl = L.Routing.control({
        waypoints: [L.latLng(start), L.latLng(end)],
        routeWhileDragging: false,
        lineOptions: { styles: [{ color: '#6c5ce7', weight: 6 }] }
    }).addTo(map);

    routingControl.on('routesfound', function(e) {
        const route = e.routes[0];
        const distance = route.summary.totalDistance / 1000;
        const duration = Math.round(route.summary.totalTime / 60);

        document.getElementById('distance').textContent = distance.toFixed(2) + ' km';
        document.getElementById('duration').textContent = duration + ' min';

        const passengers = parseInt(document.querySelector('input[name="passengers"]').value) || 1;
        const rideType = document.querySelector('select[name="ride_type"]').value;
        calculatePrice(distance, passengers, rideType);
    });

    map.fitBounds(L.latLngBounds([start, end]));
}

document.querySelector('input[name="passengers"]').addEventListener('change', () => {
    const distance = parseFloat(document.getElementById('distance').textContent) || 0;
    const rideType = document.querySelector('select[name="ride_type"]').value;
    const passengers = parseInt(document.querySelector('input[name="passengers"]').value) || 1;
    calculatePrice(distance, passengers, rideType);
});

document.querySelector('select[name="ride_type"]').addEventListener('change', () => {
    const distance = parseFloat(document.getElementById('distance').textContent) || 0;
    const passengers = parseInt(document.querySelector('input[name="passengers"]').value) || 1;
    const rideType = document.querySelector('select[name="ride_type"]').value;
    calculatePrice(distance, passengers, rideType);
});

document.getElementById('bookingForm').addEventListener('submit', function(e) {
    const total = parseFloat(document.getElementById('hidden_total_amount').value);
    if (!total || total <= 0) {
        e.preventDefault();
        alert('Please select pickup and drop locations to calculate price');
    }
});

window.onload = initMap;
</script>

<?php include 'footer.php'; ?>
