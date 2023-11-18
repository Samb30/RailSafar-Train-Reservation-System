<?php
session_start();
include('assets/inc/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $userName = $_SESSION['username'];

  $passName = $_POST['userFname'];
  $passUame = $_POST['userUname'];
  $passPhone = $_POST['userPhone'];
  $passBday = $_POST['userBday'];
  $passEmail = $_POST['userEmail'];
  $passAddr = $_POST['userAddr'];

  $query = "update users_details set userFname = ?, userEmail = ?, userPhone=?,userBday=?,userAddr=?,userUname = ? where userUname=?";
  $stmt = $mysqli->prepare($query);
  $rc = $stmt->bind_param("sssssss", $passName, $passEmail, $passPhone,$passBday,$passAddr,$passUame, $userName);
  $stmt->execute();

  if ($stmt) {
    $succ = "Your  Profile  Has Been Updated";
    header("Location:pass-profile.php");
  } else {
    $err = "Please Try Again Later";
  }
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
      height: 580px;
      margin: 20px auto;
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
      align-items: center;
      justify-content: center;
      margin-top: 20px;
      cursor: pointer;
    }


    .update-info input {
      width: 80%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-family: "Montserrat", sans-serif;
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
        <div class="profile-avatar">
          <img src="./assets1/avatar.png" alt="Profile Avatar">
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="update-info">
            <input type="text" id="newName" name="userFname" value="<?php echo $row->userFname; ?>">
          </div>

          <div class="update-info">
            <input type="text" id="newUname" name="userUname" value="<?php echo $row->userUname; ?>">
          </div>

          <div class="update-info">
            <input type="text" id="newPhone" name="userPhone" value="<?php echo $row->userPhone; ?>">
          </div>

          <div class="update-info">
            <input type="date" id="newBday" name="userBday" placeholder="Date of Birth" value="<?php echo $row->userBday; ?>">
          </div>

          <div class="update-info">
            <input type="text" id="newEmail" name="userEmail" value="<?php echo $row->userEmail; ?>">
          </div>

          <div class="update-info">
            <input type="text" id="newAddr" name="userAddr" value="<?php echo $row->userAddr; ?>">
          </div>

          <div class="button-container">
            <button class="logout-button" type="submit">Update</button>
            <a href="pass-profile-password.php" class="logout-button" style="color:white;">Change Password</a>
          </div>
        </form>
      </div>
    <?php } ?>
  </div>

  <div class="popup-overlay" id="popupOverlay">
    <div class="popup-content">
      <span class="close-popup" onclick="closePopup()">×</span>
      <label for="updateText">Update Text:</label><br>
      <input type="text" id="updateText"><br><br>
      <button onclick="updateProfile()">Update</button>
    </div>
  </div>

  <script>
    let selectedInfo = '';

    function openPopup(info) {
      selectedInfo = info;
      document.getElementById("popupOverlay").style.display = "flex";
    }

    function closePopup() {
      document.getElementById("popupOverlay").style.display = "none";
    }

    function updateProfile() {
      const updatedText = document.getElementById("updateText").value;
      const selectedElement = document.querySelector(div[onclick = "openPopup('${selectedInfo}')"]);
      selectedElement.textContent = updatedText;
      document.getElementById("updateText").value = ""; // Reset the input value
      closePopup();
    }
  </script>
</body>

</html>