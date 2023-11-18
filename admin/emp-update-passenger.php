<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['Update_Passenger'])) {
  $passengerId = $_GET['passengerId'];
  $passengerFname = $_POST['passengerFname'];
  $passengerLname = $_POST['passengerLname'];
  $passengerAge = $_POST['passengerAge'];
  $passengerGender = $_POST['passengerGender'];
  $passengerAddress = $_POST['passengerAddress'];

  $query = "update passenger_details set passengerFname=?, passengerLname=?, passengerAge=?, passengerGender=?, passengerAddress=? where passengerId = ?";
  $stmt = $mysqli->prepare($query);
  $rc = $stmt->bind_param('sssssi', $passengerFname, $passengerLname, $passengerAge, $passengerGender, $passengerAddress, $passengerId);
  $stmt->execute();

  if ($stmt) {
    $success = "Passenger Account Updated";
  } else {
    $err = "Please Try Again Or Try Later";
  }
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
      max-width: 550px;
      margin: 70px auto;
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

  <?php if (isset($success)) { ?>
    <script>
      setTimeout(function() {
          swal("Success!", "<?php echo $success; ?>!", "success");
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
  $aid = $_GET['passengerId'];
  $ret = "select * from passenger_details where passengerId=?";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $aid);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($row = $res->fetch_object()) {
  ?>
    <div class="wrapper">
      <form method="POST" class="form-container">
        <br>
        <div class="h4 font-weight-bold text-center mb-3">Update Passenger Details</div>
        <br>
        <div class="form-group d-flex align-items-center">
          <input autocomplete="off" class="form-control" name="passengerFname" type="text" value="<?php echo $row->passengerFname; ?> " placeholder="First Name">
        </div>
        <div class="form-group d-flex align-items-center col">
          <input class="form-control" name="passengerLname" type="text" value="<?php echo $row->passengerLname; ?>" placeholder="Last Name">
        </div>

        <div class="form-group d-flex align-items-center">

          <input class="form-control" name="passengerAge" type="text" value="<?php echo $row->passengerAge; ?>" placeholder="Age">
        </div>

        <div class="form-group d-flex align-items-center">

          <input class="form-control" name="passengerGender" type="text" value="<?php echo $row->passengerGender; ?>" placeholder="Gender">
        </div>

        <div class="form-group d-flex align-items-center">
          <input class="form-control" name="passengerAddress" type="text" value="<?php echo $row->passengerAddress; ?>" placeholder="Address">
        </div>


        <button class="btn btn-primary mb-3" value="Update_Passenger" name="Update_Passenger" type="submit">Update</button>
        <a class="btn btn-primary mb-3" href="emp-manage-passengers.php">Cancel</a>

      </form>
    </div>
  <?php } ?>
</body>

</html>