<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['Update_Train'])) {
  $trainNumber = $_GET['trainNumber'];
  $trainName = $_POST['trainName'];
  $stationName = $_POST['stationName'];
  $startPoint = $_POST['startPoint'];
  $destinationPoint = $_POST['destinationPoint'];
  $arrivalTime = $_POST['arrivalTime'];
  $departureTime = $_POST['departureTime'];
  $distance = $_POST['distance'];
  $Fare  = $_POST['Fare'];
  $Seats = $_POST['Seats'];

  $query = "update train_details set trainName= ?, stationName = ?, startPoint = ?, destinationPoint = ?, arrivalTime = ?, departureTime  = ?, distance = ?, Fare = ?, Seats = ? where trainNumber = ?";
  $stmt = $mysqli->prepare($query);
  $rc = $stmt->bind_param('sssssssssi', $trainName, $stationName, $startPoint, $destinationPoint, $arrivalTime, $departureTime, $distance, $Fare, $Seats, $trainNumber);
  $stmt->execute();
  if ($stmt) {
    $succ = "Train Updated";
  } else {
    $err = "Please Try Again Later";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
  <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert library -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    .wrapper {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px 30px;
      height: 500px;
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

  <?php
  $aid = $_GET['trainNumber'];
  $ret = "select * from train_details where trainNumber=?";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $aid);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($row = $res->fetch_object()) {
  ?>
    <div class="wrapper">
      <form method="POST" class="form-container">
        <br>
        <div class="h4 font-weight-bold text-center mb-3">Update Train Details</div>
        <br>
        <div class="form-row">
          <div class="form-group d-flex align-items-center">
            <input autocomplete="off" class="form-control" name="trainName" type="text" value="<?php echo $row->trainName; ?>" placeholder="Train Name">
          </div>
          <div class="form-group d-flex align-items-center col">
            <input class="form-control" name="stationName" type="text" value="<?php echo $row->stationName; ?>" placeholder="Station Name">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group d-flex align-items-center">
            <input class="form-control" name="startPoint" type="text" value="<?php echo $row->startPoint; ?>" placeholder="Current Station">
          </div>

          <div class="form-group d-flex align-items-center">

            <input class="form-control" name="destinationPoint" type="text" value="<?php echo $row->destinationPoint; ?>" placeholder="Destination Station">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group d-flex align-items-center">
            <input class="form-control" name="arrivalTime" type="text" value="<?php echo $row->arrivalTime; ?>" placeholder="Arrival Time">
          </div>

          <div class="form-group d-flex align-items-center">
            <input class="form-control" name="departureTime" type="text" value="<?php echo $row->departureTime; ?>" placeholder="Departure Time">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group d-flex align-items-center">
            <input class="form-control" name="distance" type="text" value="<?php echo $row->distance; ?>" placeholder="Distance">
          </div>

          <div class="form-group d-flex align-items-center">
            <input class="form-control" name="Fare" type="text" value="<?php echo $row->Fare; ?>" placeholder="Fare">
          </div>
        </div>

        <div class="form-group d-flex align-items-center">
          <input class="form-control" name="Seats" type="text" value="<?php echo $row->Seats; ?>" placeholder="Seats">
        </div>
        <button class="btn btn-primary mb-3" value="Update_Train" name="Update_Train" type="submit">Update Profile</button>
        <a class="btn btn-primary mb-3" href="emp-manage-train.php">Cancel</a>

      </form>
    </div>
  <?php } ?>
</body>

</html>