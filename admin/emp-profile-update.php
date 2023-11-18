<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
if (isset($_POST['Update_Profile'])) {
  $adminFname = $_POST['adminFname'];
  $adminLname = $_POST['adminLname'];
  $adminEmail = $_POST['adminEmail'];
  $adminUname = $_POST['adminUname'];
  $adminId = $_SESSION['adminId'];

  $query = "update admin_details set adminFname = ?, adminLname = ?,  adminEmail = ?, adminUname = ? where adminId=?";
  $stmt = $mysqli->prepare($query);
  $rc = $stmt->bind_param('ssssi', $adminFname, $adminLname,  $adminEmail, $adminUname, $adminId);
  $stmt->execute();

  if ($stmt) {
    $succ = "Your  Profile  Has Been Updated";
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
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    .wrapper {
      max-width: 500px;
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
      border: 1px solid #4D4C7D;
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
  <div class="main-content container-fluid">
    <?php
    $aid = $_SESSION['adminId'];
    $ret = "select * from admin_details where adminId=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $aid);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
    ?>

      <div class="wrapper">
        <form method="POST" class="form-container">
          <br>
          <div class="h4 font-weight-bold text-center mb-3">Update Profile</div>
          <br>
          <div class="form-group d-flex align-items-center">
            <input autocomplete="off" class="form-control" name="adminFname" id="adminFname" type="text" value="<?php echo $row->adminFname; ?> " placeholder="First Name">
          </div>
          <div class="form-group d-flex align-items-center col">
            <input class="form-control" name="adminLname" id="adminLname" type="text" value="<?php echo $row->adminLname; ?>" placeholder="Last Name">
          </div>

          <div class="form-group d-flex align-items-center">

            <input class="form-control" name="adminEmail" id="adminEmail" type="text" value="<?php echo $row->adminEmail; ?>" placeholder="Email Address">
          </div>

          <div class="form-group d-flex align-items-center">

            <input class="form-control" name="adminUname" id="adminUname" value="<?php echo $row->adminUname; ?>" type="text" placeholder="Username">
          </div>

          <button class="btn btn-primary mb-3" name="Update_Profile" type="submit">Update Profile</button>
          <a class="btn btn-primary mb-3" href="emp-profile.php">Cancel</a>

        </form>
      </div>

    <?php } ?>
</body>

</html>