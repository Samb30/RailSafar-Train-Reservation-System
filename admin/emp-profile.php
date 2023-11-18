<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <style>
    .content_wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .card {
      cursor: pointer;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 1.5rem;
      height: 350px;
      border-radius: 30px;
      background: rgba(255, 255, 255, 0.05);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(16.5px);
      -webkit-backdrop-filter: blur(16.5px);
      border-radius: 30px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      margin: 50px;
      width: calc(25% - 30px);
      color: #000;
    }

    .location {
      font-family: Poppins;
      font-style: normal;
      font-weight: 500;
      font-size: 22px;
      line-height: 22px;
      text-transform: capitalize;
      color: #000;

    }

    .degree {
      font-size: 28px;
      line-height: 10px;
      text-transform: capitalize;
      color: #23226B;
      font-family: 'Poppins', sans-serif;
    }

    .card-image img {
      position: relative;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-content {
      text-align: center;
      margin-top: 15px;
    }

    .button-container .btn.btn-primary {
      position: relative;
      color: #000;
      padding: 0.8rem 3rem;
      border-radius: 60px;
      border: 2px solid #F99417;
      background-color: inherit;
      box-shadow: none;
      overflow: hidden;
      margin: 10px auto;
      font-size: 15px;
      font-family: 'Poppins', sans-serif;
    }

    .button-container .btn.btn-primary:hover {
      background-color: #b4b4b433;
      color: #000;
    }
  </style>
</head>

<body>

  <?php include('assets/inc/navbar.php'); ?>

  <?php
  $aid = $_SESSION['adminId'];
  $ret = "select * from admin_details where adminId=?";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $aid);
  $stmt->execute();
  $res = $stmt->get_result();

  while ($row = $res->fetch_object()) {
  ?>

    <div class="content_wrapper">
      <div class="card 1st_card">
        <div class="card-image">
          <img src="assets/img/profile.png" alt="cloud" border="0">
        </div>
        <div class="card-content">
          <h3 class="degree"><?php echo $row->adminFname; ?> <?php echo $row->adminLname; ?></h3>
          <h2 class="location"><?php echo $row->adminUname; ?></h2>
        </div>
        
        <div class="button-container">
          <button class="btn btn-primary mb-3" onclick="changePassword()">Change Password</button><br>
        </div>
        <div class="button-container">
          <button class="btn btn-primary mb-3" onclick="updateDetails()">Update Details</button>
        </div>
      </div>
    </div>

    <script type='text/javascript'>
      var myLink = document.querySelector('a[href="#"]');
      myLink.addEventListener('click', function(e) {
        e.preventDefault();
      });
    </script>

    <script type='text/javascript'>
      var myLink = document.querySelector('a[href="#"]');
      myLink.addEventListener('click', function(e) {
        e.preventDefault();
      });

      function changePassword() {
        window.location.href = 'emp-profile-password.php';
      }

      function updateDetails() {
        window.location.href = 'emp-profile-update.php';
      }
    </script>

  <?php } ?>
</body>

</html>