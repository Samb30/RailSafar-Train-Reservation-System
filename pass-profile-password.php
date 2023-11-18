<?php
session_start();
include('assets/inc/config.php');

$userName = $_SESSION['username'];

if (isset($_POST['Update_Password'])) {
  $oldusersPwd = $_POST['oldusersPwd'];
  $newusersPwd = $_POST['newusersPwd'];
  $confirmusersPwd = $_POST['confirmusersPwd'];
  $userName = $_SESSION['username'];

  $query = "SELECT userPwd FROM users_details WHERE userUname=?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('s', $userName);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($userPwd);
    $stmt->fetch();

    if ($oldusersPwd === $userPwd) {

      $hashedNewPwd = password_hash($newusersPwd, PASSWORD_DEFAULT);

      $updateQuery = "UPDATE users_details SET userPwd=? WHERE userUname=?";
      $updateStmt = $mysqli->prepare($updateQuery);
      $updateStmt->bind_param('ss', $newusersPwd, $userName);
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
  <link rel="stylesheet" href="css/navbar.css" type="text/css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      background-color: #f2f2f2;
      font-family: "Montserrat", sans-serif;
      margin: 0;
      padding: 0;
    }

    .main {
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .profile-container {
      width: 400px;
      height: 330px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .profile-avatar {
      display: block;
      margin: 0 auto;
      width: 150px;
      height: 150px;
      border-radius: 50%;
      background-color: #ccc;
      text-align: center;
      line-height: 150px;
      font-size: 20px;
      color: #888;
      animation: pulse 2s infinite;
    }

    .profile-avatar img {
      width: 80%;
      height: 80%;
      border-radius: 30%;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
      }

      30% {
        transform: scale(1.1);
      }

      80% {
        transform: scale(1);
      }
    }

    .profile-info {
      margin-top: 20px;
      text-align: center;
    }

    .button-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 20px;
    }

    .update-info {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
      cursor: pointer;
    }

    .update-info i {
      font-size: 20px;
      margin-right: 10px;
    }

    .update-info input {
      width: 80%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-right: 10px;
    }

    .update-info div {
      display: flex;
      flex-direction: column;
    }

    .logout-button {
      padding: 10px 20px;
      background-color: #000000;
      color: white;
      text-decoration: none;
      font-family: "Montserrat", sans-serif;
      border-radius: 20px;
      margin-bottom: 10px;
      text-align: center;
      transition: background-color 0.3s, color 0.3s;
      box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    }

    .logout-button:hover {
      background-color: #fff;
      color: #000;
    }

    .popup-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      background: white;
      padding: 20px;
      border-radius: 5px;
      text-align: center;
    }

    .close-popup {
      cursor: pointer;
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      color: #888;
    }
  </style>

</head>

<body>

  <div class="main">
    <?php include 'navbar.php'; ?>

    <?php
    $userName = $_SESSION['username'];
    $ret = "select * from users_details where userUname=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('s', $userName);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
    ?>
      <div class="profile-container">

      <h2>Change Password</h2>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="update-info">
            <input autocomplete="off" class="form-control" name="oldusersPwd" id="oldusersPwd" type="password" placeholder="Old Password">
          </div>

          <div class="update-info">
            <input autocomplete="off" class="form-control" name="newusersPwd" id="oldusersPwd" type="password" placeholder="New Password">
          </div>

          <div class="update-info">
            <input autocomplete="off" class="form-control" name="confirmusersPwd" id="oldusersPwd" type="password" placeholder="Confirm New Password">
          </div>

          <div class="button-container">
            <button class="logout-button" name="Update_Password" type="submit">Change Password</button>
            <a href="pass-profile.php" class="logout-button" style="color:white;">Cancel</a>
          </div>
        </form>
      </div>
    <?php } ?>
  </div>
</body>

</html>