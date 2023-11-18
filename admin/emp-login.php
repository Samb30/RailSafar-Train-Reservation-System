<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['emp_login'])) {
  $adminEmail = $_POST['adminEmail'];
  $adminPwd = $_POST['adminPwd'];

  $stmt = $mysqli->prepare("SELECT adminEmail ,adminPwd , adminId FROM admin_details WHERE adminEmail=? and adminPwd=? "); //sql to log in user
  $stmt->bind_param('ss', $adminEmail, $adminPwd);
  $stmt->execute();
  $stmt->bind_result($adminEmail, $adminPwd, $adminId);
  $rs = $stmt->fetch();

  $_SESSION['adminId'] = $adminId;

  if ($rs) {
    header("location:emp-dashboard.php");
  } else {
    $error = "Access Denied Please Check Your Credentials";
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
      max-width: 400px;
      margin: 80px auto;
      padding: 20px 30px;
      height: 430px;
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
  <div class="wrapper">
    <form method="POST" class="form-container">

      <div class="text-center"><img class="logo-img" src="assets/img/black_logo.png" alt="logo" width="150" height="85"></div>
      <br>
      <div class="h5 font-weight-bold text-center mb-3">Please enter your login details.</div>
      <br>
      <div class="form-group d-flex align-items-center col">
        <input autocomplete="off" class="form-control" name="adminEmail" id="trainNumber" type="text" placeholder="Email">
      </div>
      <div class="form-group d-flex align-items-center col">
        <input class="form-control" name="adminPwd" id="trainName" type="password" placeholder="Password">
      </div>
      <br>
      <button class="btn btn-primary mb-3" type="submit" name="emp_login" value="Log In">Log In</button>
      <a class="btn btn-primary mb-3" href="../index.php">Home</a>

    </form>
  </div>
</body>

</html>