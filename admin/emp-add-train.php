<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_POST['add_train'])) {
  $trainNumber = intval($_POST['trainNumber']);
  $trainName = $_POST['trainName'];
  $stationName = $_POST['stationName'];
  $startPoint = $_POST['startPoint'];
  $destinationPoint = $_POST['destinationPoint'];
  $arrivalTime = $_POST['arrivalTime'];
  $departureTime = $_POST['departureTime'];
  $distance = $_POST['distance'];
  $Seats = intval($_POST['Seats']);
  $Fare = floatval($_POST['Fare']);

  $query = "INSERT INTO train_details (trainNumber, trainName, stationName, startPoint, destinationPoint, arrivalTime, departureTime, distance, Fare, Seats) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $mysqli->prepare($query);

  if (!$stmt) {
    die('Error in query: ' . $mysqli->error);
  }

  $rc = $stmt->bind_param('sssssssssd', $trainNumber, $trainName, $stationName, $startPoint, $destinationPoint, $arrivalTime, $departureTime, $distance, $Fare, $Seats);

  if (!$rc) {
    die('Error binding parameters: ' . $stmt->error);
  }

  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $succ = "Train Added";
  } else {
    $err = "Please Try Again Later";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    .wrapper {
      max-width: 600px;
      margin: 80px auto;
      padding: 20px 30px;
      height: 450px;
      background: rgba(255, 255, 255, 0.05);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(16.5px);
      -webkit-backdrop-filter: blur(16.5px);
      border-top: 1px solid #ffffff6e;
      border-left: 1px solid #ffffff6e;
      border-radius: 15px;
    }

    .wrapper .form-group {
      border-bottom: 1px solid #ccc;
      margin-bottom: 1.5rem;
    }

    .wrapper .form-group:hover {
      border-bottom: 1px solid #eee;
    }

    .wrapper .form-group .form-control {
      background: inherit;
      border: none;
      border-radius: 0px;
      box-shadow: none;
      color: #000;
    }

    .wrapper .form-group input::placeholder {
      color: #474E68;
    }

    .wrapper .form-group input:focus::placeholder {
      opacity: 0;
    }

    .wrapper .btn.btn-primary {
      position: relative;
      color: #000;
      padding: 0.3rem 1rem;
      border-radius: 20px;
      border: 1px solid #ddd;
      background-color: inherit;
      box-shadow: none;
      overflow: hidden;
    }

    .wrapper .btn.btn-primary:hover {
      background-color: #b4b4b433;
      color: #000;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 80px;
    }

    .form-group {
      flex: 1;
    }
  </style>
</head>

<body>

  <?php include('assets/inc/navbar.php'); ?>

  <?php if (isset($succ)) { ?>
    <script>
      setTimeout(function() {
          swal("Success!", "<?php echo $succ; ?>!", "success");
        },
        100);
    </script>

  <?php } ?>
  <?php if (isset($err)) { ?>
    <script>
      setTimeout(function() {
          swal("Failed!", "<?php echo $err; ?>!", "Failed");
        },
        100);
    </script>
  <?php } ?>

  <div class="wrapper">
    <form method="POST" class="form-container">
      <div class="h5 font-weight-bold text-center mb-3">Fill the Train Details</div>

      <div class="form-row">
        <div class="form-group d-flex align-items-center col">
          <input autocomplete="off" class="form-control" name="trainNumber" id="trainNumber" type="number" placeholder="Train Number">
        </div>
        <div class="form-group d-flex align-items-center col">
          <input class="form-control" name="trainName" id="trainName" type="text" placeholder="Train Name">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group d-flex align-items-center">
          <input class="form-control" name="stationName" id="stationName" type="text" placeholder="Station Name">
        </div>
        <div class="form-group d-flex align-items-center">
          <input class="form-control" name="Seats" id="Seats" type="number" placeholder="Seats">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group d-flex align-items-center col">
          <input class="form-control" name="startPoint" id="startPoint" type="text" placeholder="Start Station">
        </div>
        <div class="form-group d-flex align-items-center col">
          <input class="form-control" name="destinationPoint" id="destinationPoint" type="text" placeholder="Destination Station">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group d-flex align-items-center col">
          <input class="form-control" name="arrivalTime" id="arrivalTime" type="text" placeholder="Arrival Time">
        </div>
        <div class="form-group d-flex align-items-center col">
          <input class="form-control" name="departureTime" id="departureTime" type="text" placeholder="Departure Time">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group d-flex align-items-center">
          <input class="form-control" name="distance" id="distance" type="text" placeholder="Distance">
        </div>
        <div class="form-group d-flex align-items-center">
          <input class="form-control" name="Fare" id="Fare" type="text" placeholder="Train Fare">
        </div>
      </div>

      <button class="btn btn-primary mb-3" name="add_train" type="submit">Add Train</button>
      <a class="btn btn-primary mb-3" href="emp-dashboard.php">Cancel</a>

    </form>
  </div>

</body>

</html>