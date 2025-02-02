<?php
// Database connection
include('connect.php');


// // Fetch car rental data from 'cars_deals' table
// $sql = "SELECT * FROM cars_deals";
// $result = $conn->query($sql);

// Query to get cars
$stmt = $conn->prepare("SELECT * FROM cars_deals");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No cars available for booking.";
    exit();
}

// print_r($result->fetch_assoc());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <title>CARS</title>
    <style>
        /* Basic styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px 0;
        }

        header nav {
            display: flex;
            justify-content: center;
        }

        .nav__logo a {
            text-decoration: none;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .section__container {
            padding: 50px 20px;
        }

        .services_tab {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn.active {
            background-color: #333;
            color: white;
        }

        .deals__card {
            background-color: white;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 8px;
        }

        .deals__card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .deals__rating {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .deals__rating span {
            margin-right: 5px;
            color: #f1c40f;
        }

        .deals__card h4 {
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .deals__card__grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .deals__card__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
        }

        .deals__card__footer h3 {
            color: #e74c3c;
        }

        .deals__card__footer a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            display: flex;
            align-items: center;
        }

        .deals__card__footer a:hover {
            color: #e74c3c;
        }

        .deals__card__footer a span {
            margin-left: 10px;
            font-size: 20px;
        }

        .tab__content {
            display: none;
        }

        .tab__content.active {
            display: block;
        }
    </style>
</head>
<body>

<header>
  <nav>
    <div class="nav__header">
      <div class="nav__logo">
        <a href="#"> CARS</a>
      </div>
    </div>
  </nav>
</header>

<section class="section__container Cars__container" id="cars">


  <h2>Select a Car to Book</h2>

 
    <div class="services_tab">
      <?php
      // Predefined brands to display tabs
      $brands = ['Tesla', 'Mitsubishi', 'Mazda', 'Toyota', 'Honda'];

      // Loop through the brands to create the tabs
      foreach ($brands as $brand) {
          echo "<button type='button' class='btn' data-id='{$brand}'>{$brand}</button>";
      }
      ?>
    </div>

  <!-- Tesla Tab Content -->
  <div id="Tesla" class="tab__content active">
    <?php 
    while ($row = $result->fetch_assoc()) {
      ?>
      <input type="hidden" name="car_id" value="<?php echo $row['id']?>">
    <div class="deals__card">
      <img src="<?php echo $row['image']?> "alt="<?php echo $row['car_model']?>" />
      <div class="deals__rating">
        <?php for($i =0 ; $i < round($row['rating']); $i++  ){?>
        <span><i class="ri-star-fill"></i></span>
        <?php }?>
        <span><?php echo $row['rating']?></span>
      </div>
      <h4><?php echo $row['car_model']?>E</h4>
      <div class="deals__card__grid">
        <div>
          <span><i class="ri-group-line"></i></span><?php echo $row['people_capacity']?>
        </div>
        <div>
          <span><i class="ri-steering-2-line"></i></span> Autopilot
        </div>
        <div>
          <span><i class="ri-speed-up-line"></i></span> <?php echo $row['range_distance']?>
        </div>
        <div>
          <span><i class="ri-car-line"></i></span> Electric
        </div>
      </div>
      <hr />
      <div class="deals__card__footer">
        <h3><?php echo $row['price_per_day']?><span>/Per Day</span></h3>
      <form action="details.php" method="GET">
      
    <input type="hidden" name="car_id" value="<?php echo $row['car_model']?>">
    <button type="submit">
      
          Book Now
          <span><i class="ri-arrow-right-line"></i></span>
        
    </button>
    
  </form>
        
      </div>
    </div>
<?php }?>

    
  </div>
</section>


<script>
  // Handle tab switching based on clicked brand
  const tabs = document.querySelectorAll('.btn');
  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      // Remove active class from all tabs and hide all tab content
      tabs.forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab__content').forEach(content => content.classList.remove('active'));

      // Add active class to clicked tab and display corresponding content
      this.classList.add('active');
      const brand = this.getAttribute('data-id');
      document.getElementById(brand).classList.add('active');
    });
  });
</script>

</body>
</html>

<?php $conn->close(); ?>
