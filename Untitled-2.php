<body>

<div class="container">
    <!-- Book Now Button with PHP handling -->
    <form method="POST" action="bookings.php" id="bookingForm">
        <h2>Book Your Ride</h2>

        <!-- Car Selection (Dynamic from DB) -->
        <label for="carSelect">Select Your Car</label>
        <select id="carSelect" name="car_id" required>
            <option value="">Select a Car</option>
            <?php
            // Populate the car selection dynamically from the database
            while ($car = $carResult->fetch_assoc()) {
                echo '<option value="' . $car['CID'] . '" data-price="' . $car['price'] . '">' . $car['model'] . ' - ' . $car['category'] . '</option>';
            }
            ?>
        </select>

        <!-- Location Selection (Dynamic from DB) -->
        <label for="locationSelect">Select Rental Location</label>
        <select id="locationSelect" name="location_id" required>
            <option value="">Select a Location</option>
            <?php
            // Populate the location dropdown dynamically from the database
            while ($location = $locationResult->fetch_assoc()) {
                echo '<option value="' . $location['RID'] . '">' . $location['location_name'] . '</option>';
            }
            ?>
        </select>

        <!-- Date Picker -->
        <label for="pickUpDate">Pick-Up Date</label>
        <input type="datetime-local" id="pickUpDate" name="pick_up_date" required />

        <!-- Car Model and Price (You can pre-fill these from the database or set hidden fields) -->
        <input type="hidden" id="carModel" name="car_model" />
        <input type="hidden" id="carPrice" name="car_price" />

        <button type="submit">Rent Now</button>
    </form>
    <script>
    // Capture the car selection change and set hidden fields for car model and price
    document.getElementById('carSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const carModel = selectedOption.text;
        const carPrice = selectedOption.getAttribute('data-price');

        // Set the car details in hidden fields
        document.getElementById('carModel').value = carModel;
        document.getElementById('carPrice').value = carPrice;
    });
</script>
