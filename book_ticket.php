<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

$conn = new mysqli($servername, $username, $password, $dbname);
$username = $_SESSION['username'];
$passengerIdQuery = "SELECT userID FROM users_details WHERE userUname = '$username'";

// Execute the query
$result = $conn->query($passengerIdQuery);

// Check if the query was successful
if ($result) {
  // Check if any rows were returned
  if ($result->num_rows > 0) {
    // Fetch the result
    $rowPassengerId = $result->fetch_assoc();

    // Retrieve pass_id from the result
    $userid = $rowPassengerId['userID'];
  } else {
    // Handle the case where pass_id is not found for the current user
    echo "Passenger ID not found for username: $username";
  }
} else {
  // Handle the case where the query execution failed
  echo "Error executing the query: " . $conn->error;
}



if (!isset($_SESSION['username'])) {
  // User is not logged in, redirect to the login page
  header("Location: pass-regi.php"); // Replace "login.php" with the actual login page URL

}
$trainNumber = isset($_GET['train_number']) ? $_GET['train_number'] : '';
$trainName = isset($_GET['train_name']) ? urldecode($_GET['train_name']) : '';
$stationName = isset($_GET['train_station']) ? urldecode($_GET['train_station']) : '';
$startPoint = isset($_GET['train_startPoint']) ? urldecode($_GET['train_startPoint']) : '';
$destinationPoint = isset($_GET['destinationPoint']) ? urldecode($_GET['destinationPoint']) : '';
$arrivalTime = isset($_GET['arrivalTime']) ? urldecode($_GET['arrivalTime']) : '';
$departureTime = isset($_GET['departureTime']) ? urldecode($_GET['departureTime']) : '';
$distance = isset($_GET['distance']) ? urldecode($_GET['distance']) : '';
$Seats = isset($_GET['Seats']) ? urldecode($_GET['Seats']) : '';
$Fare = isset($_GET['train_fare']) ? urldecode($_GET['train_fare']) : '';
$JourneyDate = isset($_GET['JourneyDate']) ? urldecode($_GET['JourneyDate']) : '';




if (isset($_POST['add_pass'])) {

  $passengerfname = $_POST['passengerfname']; // Assuming you have a form input with the name 'passenger_name'
  $passengerlname = $_POST['passengerlname']; // Assuming you have a form input with the name 'passenger_name'
  $passengerdob = $_POST['passengerdob'];
  $passengerGender = $_POST['passengergender'];

  $pass_birthdate = new DateTime($passengerdob);
  $currentDate = new DateTime();
  $passengerAge = $currentDate->diff($pass_birthdate)->y;

  $insertQuery = "INSERT INTO passenger_details (userId, passengerFname, passengerLname,passengerAge, passengerGender,status) VALUES ($userid, '$passengerfname','$passengerlname', $passengerAge, '$passengerGender','Not Booked')";
  $stmt = $conn->prepare($insertQuery);
  $stmt->execute();
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}
?>

<!--  -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/navbar.css" type="text/css" />
  <link rel="stylesheet" href="css/book_ticket.css" type="text/css" />

</head>

<body>
  <div class="main">
    <div class="container">
      <?php include 'navbar.php'; ?>
      <div class="title-area">
        <div class="title">
          <h2>Book Train</h2>
          <span>Dashboard / Book Train / Reserve Seat</span>
        </div>
      </div>
      <div class="container2">
        <div class="fill-space">
          <div class="fill-title">Fill All Details</div>
          <div class="hori-line"></div>
          <div class="under-line">
            <div class="details">
              <div class="f-name detail">
                <div class="detail-title">First Name</div>
                <div class="detail-content">
                  <?php
                  $sql = "SELECT userFname FROM users_details WHERE userUname = '$username'";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row['userFname'];
                  } else {
                    echo "hi";
                  } ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Last Name</div>
                <div class="detail-content">
                  <?php
                  $sql = "SELECT userLname FROM users_details WHERE userUname = '$username'";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row['userLname'];
                  } else {
                    echo "hi";
                  } ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Phone Number</div>
                <div class="detail-content">
                  <?php
                  $sql = "SELECT userPhone FROM users_details WHERE userUname = '$username'";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row['userPhone'];
                  } else {
                    echo "hi";
                  } ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Address</div>
                <div class="detail-content">
                  <?php
                  $sql = "SELECT userAddr FROM users_details WHERE userUname = '$username'";
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo $row['userAddr'];
                  } else {
                    echo "hi";
                  } ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Train Name</div>
                <div class="detail-content">
                  <?php
                  echo $trainName;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Train Number</div>
                <div class="detail-content">
                  <?php
                  echo $trainNumber;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Station Name</div>
                <div class="detail-content">
                  <?php
                  echo $stationName;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Start Point</div>
                <div class="detail-content">
                  <?php
                  echo $startPoint;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Destination Point</div>
                <div class="detail-content">
                  <?php
                  echo $destinationPoint;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Arrival Time</div>
                <div class="detail-content">
                  <?php
                  echo $arrivalTime;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Departure Time</div>
                <div class="detail-content">
                  <?php
                  echo $departureTime;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Trip Distance</div>
                <div class="detail-content">
                  <?php
                  echo $distance;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Train Seats</div>
                <div class="detail-content">
                  <?php
                  echo $Seats;
                  ?>
                </div>
              </div>
              <div class="f-name detail">
                <div class="detail-title">Train Fare</div>
                <div class="detail-content">
                  <?php
                  echo $Fare;
                  ?>
                </div>
              </div>

            </div>

            <div class="select-pass" id="select-pass">
              <div class="select-nav">
                <div class="select-title"> Passengers</div>
              </div>
              <div class="show-pass">

                <?php
                // Assuming $username is the username of the logged-in user
                $sql = "SELECT * FROM passenger_details WHERE userId = (SELECT userId FROM users_details WHERE userUname = '$username') AND status = 'Not Booked'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<div class="passenger default-pass">';
                    echo '<div class="default-pass-name">' . $row['passengerFname'] . '</div>';
                    echo '<div class="default-pass-detail">' . $row['passengerAge'] . ', ' . $row['passengerGender'] . '</div>';
                    echo '</div>';
                  }
                }
                ?>
              </div>
              <div class="add-pass-box">
                <div class="add-pass" id="add-pass" onclick="showconfirmbox()">BOOK TICKET</div>
                <div class="add-pass" id="checkout" onclick="redirectToCheckout()">CHECKOUT</div>
                <div class="add-pass" onclick="showpass()">ADD PASSENGER</div>
              </div>
            </div>

            <div class="enter-pass" id="enter-pass">
              <div class="enter-nav">
                <div class="enter-title "> Add New Passenger</div>
              </div>
              <div class="enter-show-pass ">
                <form method="post">
                  <input type="hidden" name="add_pass" value="1">
                  <fieldset class="forms_fieldset">
                    <div class="forms_field">
                      <input type="text" placeholder="First Name" name="passengerfname" required />
                    </div>
                    <div class="forms_field">
                      <input type="text" placeholder="Last Name" name="passengerlname" required />
                    </div>
                    <div class="forms_field" style="display:flex;justify-content: space-evenly;">
                      <input type="date" style="margin-right: 10px;" placeholder="Birth Date" name="passengerdob" class="forms_field-input" required />
                      <input type="text" style="margin-left: 10px;margin-right:30px" placeholder="Gender" name="passengergender" class="forms_field-input" required />
                    </div>
                  </fieldset>
              </div>
              <div class="enter-add-pass-box ">
                <input type="submit" class="enter-add-pass" onclick="hidepass();" value="ADD PASSENGER" class="forms_buttons-action">
              </div>
              </form>
            </div>
          </div>

        </div>
      </div>

      <div class="confirm-box" id="confirm-box">
        <div class="inside-confirm-box">
          <div class="input-pass">
            <fieldset class="forms_fieldset" style="width:80%;margin-top:100px;margin-left:20px;">
              <div class="forms_field">
                <input type="text" placeholder="Enter Password" id="enterpassword" required /><br>
                <div class="wrong-password" id="wrong-password">Wrong Password!!! Try Again</div>
              </div>
            </fieldset>
          </div>
          <div class="confirm-button-box">
            <div class="enter-add-pass-box" style="height:30%;">
              <input type="submit" class="enter-add-pass" onclick="verify()" value="VERIFY & CONFIRM" class="forms_buttons-action">
            </div>
          </div>

        </div>
      </div>


    </div>
  </div>

  <script>
    function verify() {

      var enteredPassword = document.getElementById('enterpassword').value;
      var xhr = new XMLHttpRequest();

      var url = 'verify-pass.php?enteredPassword=' + encodeURIComponent(enteredPassword);

      xhr.open('GET', url, true);

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var response = xhr.responseText;
          if (response === "success") {
            document.getElementById("confirm-box").style.visibility = "hidden";
            document.getElementById('enterpassword').value = '';
            document.getElementById("add-pass").style.display = "none";
            document.getElementById("checkout").style.display = "flex";

          } else if (response === "failure") {
            document.getElementById("wrong-password").style.display = "block";
          }
        }
      };
      xhr.send();

    }


    function showpass() {
      var element = document.getElementById("select-pass");
      var element2 = document.getElementById("enter-pass");
      element.style.display = "none";
      element2.style.display = "block";
    }

    function hidepass() {
      var element = document.getElementById("select-pass");
      var element2 = document.getElementById("enter-pass");
      element.style.display = "block";
      element2.style.display = "none";
    }

    function showconfirmbox() {
      var element = document.getElementById("confirm-box");
      element.style.visibility = "visible";
    }


    function redirectToCheckout() {
      let trainFare = "<?php echo $Fare; ?>"; // Assuming $Fare is defined in your PHP code
      let trainNumber = "<?php echo $trainNumber; ?>"; // Assuming $trainNumber is defined in your PHP code
      let trainName = "<?php echo $trainName; ?>"; // Assuming $trainName is defined in your PHP code
      let stationName = "<?php echo $stationName; ?>";
      let startPoint = "<?php echo $startPoint; ?>";
      let destinationPoint = "<?php echo $destinationPoint; ?>";
      let arrivalTime = "<?php echo $arrivalTime; ?>";
      let departureTime = "<?php echo $departureTime; ?>";
      let JourneyDate = "<?php echo $JourneyDate; ?>";

      let checkoutURL = `checkout.php?trainFare=${trainFare}&trainNumber=${trainNumber}&trainName=${trainName}&stationName=${stationName}&startPoint=${startPoint}&destinationPoint=${destinationPoint}&arrivalTime=${arrivalTime}&departureTime=${departureTime}&JourneyDate=${JourneyDate}`;
      window.location.href = checkoutURL; // Redirect to checkout.php with both parameters
    }
  </script>
</body>

</html>