<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_POST['Update_Password'])) {
  $oldAdminPwd = $_POST['oldAdminPwd'];
  $newAdminPwd = $_POST['newAdminPwd'];
  $confirmAdminPwd = $_POST['confirmAdminPwd'];
  $aid = $_SESSION['adminId'];

  $query = "SELECT adminPwd FROM admin_details WHERE adminId=?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('i', $aid);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($adminPwd);
    $stmt->fetch();

    if ($oldAdminPwd === $adminPwd) {

      $hashedNewPwd = password_hash($newAdminPwd, PASSWORD_DEFAULT);

      $updateQuery = "UPDATE admin_details SET adminPwd=? WHERE adminId=?";
      $updateStmt = $mysqli->prepare($updateQuery);
      $updateStmt->bind_param('si', $newAdminPwd, $aid);
      $updateStmt->execute();

      if ($updateStmt) {
        $succ1 = "Password Updated Successfully";
      } else {
        $err = "Failed to Update Password";
      }
    } else {
      $err = "Old Password is Incorrect";
    }
  } else {
    $err = "User not found";
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
      max-width: 500px;
      margin: 80px auto;
      padding: 20px 30px;
      height: 400px;
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

  <?php if (isset($succ1)) { ?>
    <script>
      setTimeout(function() {
          swal("Success!", "<?php echo $succ1; ?>!", "success");
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
        <div class="h4 font-weight-bold text-center mb-3">Change Password</div>
        <br>
        <div class="form-group d-flex align-items-center">
          <input autocomplete="off" class="form-control" name="oldAdminPwd" id="oldAdminPwd" type="password" placeholder="Old Password">
        </div>
        <div class="form-group d-flex align-items-center col">

          <input class="form-control" name="newAdminPwd" id="newAdminPwd" type="password" placeholder="New Password">
        </div>

        <div class="form-group d-flex align-items-center">

          <input class="form-control" name="confirmAdminPwd" id="confirmAdminPwd" type="password" placeholder="Confirm New Password">
        </div>

        <button class="btn btn-primary mb-3" name="Update_Password" type="submit">Change Password</button>
        <a class="btn btn-primary mb-3" href="emp-profile.php">Cancel</a>

      </form>
    </div>
  <?php } ?>

  </div>
</body>

</html>