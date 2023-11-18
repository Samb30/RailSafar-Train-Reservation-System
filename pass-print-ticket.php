<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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

$pnrNumber = $_GET['pnrNumber'];
$trainNumber = $_GET['trainNumber'];
$trainName = $_GET['trainName'];
$startPoint = $_GET['startPoint'];
$destinationPoint = $_GET['destinationPoint'];
$arrivalTime = $_GET['arrivalTime'];
$bookingDate = $_GET['bookingDate'];
$Fare = $_GET['Fare'];
?>
<!DOCTYPE html>
<html lang="en">
<!--Head-->
<!--End Head-->
<link rel="stylesheet" href="css/navbar.css" type="text/css" />
<style>
  body {
    margin: 0;
    font-family: "Montserrat", sans-serif;
    background-color: white;
    overflow-x: hidden;
  }
</style>

<body>
  <?php include('navbar.php'); ?>
  <div class="be-wrapper be-fixed-sidebar">
    <!--Nav Bar-->

      <?php
      $userName = $_SESSION['username'];
      $ret = "select * from reservation_details where userId=?"; //fetch details of pasenger
      $stmt = $conn->prepare($ret);
      $stmt->bind_param('i', $userid);
      $stmt->execute(); //ok
      $res = $stmt->get_result();
      //$cnt=1;
      while ($row = $res->fetch_object()) {
      ?>
        <!--get details of logged in user-->
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <div id='printReceipt' class="invoice" style="border: 2px solid #000;">
                <div class="row invoice-header">
                  <div class="col-sm-7" style="display: flex; align-items: center;">
                    <div class="invoice-logo"></div>
                  </div>
                  <div class="col-sm-5" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <span class="invoice-id">e-Ticketing Service</span>
                    <span class="invoice-date">Electronic Reservation Slip (Personal User)</span>
                  </div>
                </div>
                <div>
                  <span>Train Details: </span>
                  
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-12">
                    <table class="table table-bordered">
                      <tbody>
                        <?php
                        
                        $ret = "select * from reservation_details where userId=?"; //sql to get details of our user
                        $stmt = $conn->prepare($ret);
                        $stmt->bind_param('i', $userid);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        //$cnt=1;
                        
                        ?>
                          <tr>
                            <td>PNR Number:  <?php echo $pnrNumber ?></td>
                            <td>Train Number : <?php echo $trainNumber; ?></td>
                            <td>Train Name : <?php echo $trainName; ?></td>

                          </tr>
                          <tr>
                            <td>Arrival Time : <?php echo $arrivalTime; ?></td>
                            <td>Destination Point : <?php echo $destinationPoint; ?></td>
                          </tr>

                          <tr>
                            <td>Date of Booking : </td>
                            <td>Date of Journey : </td>
                            <td>Class : </td>
                          </tr>

                        
                      </tbody>
                    </table>
                  </div>
                </div>
                <div>
                  <span>Fare Details: </span>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-12">
                    <table class="table">
                      <tbody>
                        <?php
                        /**
                         *Lets select train booking details of logged in user using PASSENGER ID as the session
                         */
                        //$aid=$_SESSION['pass_id'];
                        $ret = "select * from reservation_details where userId=?"; //sql to get details of our user
                        $stmt = $conn->prepare($ret);
                        $stmt->bind_param('i', $userid);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        //$cnt=1;

                        $serviceCharges = 50;
                        $totalCharges = 0;

                        
                        ?>
                          <tr>
                            <td>Ticket Fare (In rupees) : Rs. <?php echo $Fare; ?></td>
                          </tr>

                          <tr>
                            <td>Service Charges: Rs. <?php echo $serviceCharges; ?></td>
                          </tr>

                          <?php $totalCharges = $Fare + $serviceCharges; ?>

                          <tr>
                            <td>Total Charges: Rs. <?php echo $totalCharges; ?></td>
                          </tr>
                        
                      </tbody>
                    </table>

                  </div>
                </div>
                <div>
                  <span>Passenger Details: </span>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-12">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>SNo.</th>
                          <th>Name</th>
                          <th>Age</th>
                          <th>Gender</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $ret = "select * from passenger_details where userId  =?"; //sql to get details of our user
                        $stmt = $conn->prepare($ret);
                        $stmt->bind_param('i', $userid);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        $serialNumber = 1;

                        while ($row = $res->fetch_object()) {
                        ?>
                          <tr>
                            <td><?php echo $serialNumber; ?></td>
                            <td><?php $full_name = $row->passengerFname. ' ' . $row->passengerLname;
                                echo $full_name ?></td>
                            <td><?php echo $row->passengerAge; ?></td>
                            <td><?php echo $row->passengerGender; ?></td>
                            <td><?php echo $row->status; ?></td>
                          </tr>

                        <?php $serialNumber++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <br>
                <div>
                  <span>Important : </span>
                  <ul>
                    <li>For details, rules, and terms and conditions, please visit our site.</li>
                    <li>E-Ticket Cancellation can be done through our site.</li>
                    <li>Have a Safe Journey!</li>
                  </ul>
                </div>
              </div>
              <hr>


              <div class="row invoice-footer">
                <div class="col-lg-12">
                  <button id="print" onclick="printContent('printReceipt');" class="btn btn-lg btn-space btn-secondary">Print</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Close logged in user instance-->
      <?php } ?>
      <!--footer-->
      <!--end footer-->
    </div>

  </div>
  <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
  <script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
  <script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  <script src="assets/js/app.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      //-initialize the javascript
      App.init();
    });
  </script>
  <!--print train ticket js-->
  <script>
    function printContent(el) {
      var restorepage = $('body').html();
      var printcontent = $('#' + el).clone();
      $('body').empty().html(printcontent);
      window.print();
      $('body').html(restorepage);
    }
  </script>
</body>

</html>