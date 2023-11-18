<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: pass-regi.php");
}
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


$trainFare = $_GET['trainFare'];
$trainNumber = $_GET['trainNumber'];
$trainName = $_GET['trainName'];
$stationName = $_GET['stationName'];
$startPoint = $_GET['startPoint'];
$destinationPoint = $_GET['destinationPoint'];
$arrivalTime = $_GET['arrivalTime'];
$departureTime = $_GET['departureTime'];
$JourneyDate = $_GET['JourneyDate'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/navbar.css" type="text/css" />
    <link rel="stylesheet" href="css/book_ticket.css" type="text/css" />
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="css/checkout.css" type="text/css" />

</head>

<body>
    <div class="main">
        <div class="container">
            <?php include 'navbar.php'; ?>
            <div class="checkout-area">
                <div class="left">
                    <div class="checkout-title">Checkout</div>
                    <div class="pass-info">

                        <?php
                        // Assuming $username is the username of the logged-in user
                        $sql = "SELECT * FROM passenger_details WHERE userId = (SELECT userId FROM users_details WHERE userUname = '$username')";
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
                    <div class="fare-info">
                        <div class="box pass-number">
                            <div class="total-pass">Total Passengers</div>
                            <div class="total-pass-number"><?php echo $result->num_rows ?></div>
                        </div>
                        <div class="box single-pass">
                            <div class="total-pass">Ticket Fare</div>
                            <div class="total-pass-number"><?php echo $trainFare ?></div>

                        </div>
                        <?php
                        if (!isset($_SESSION['gstAmount'])) {
                            // Generate a random GST amount if it hasn't been generated before
                            $_SESSION['gstAmount'] = rand(100, 200);
                        }

                        $gstAmount = $_SESSION['gstAmount'];
                        $totalfare = $result->num_rows * $trainFare;
                        $totalFare = $totalfare + $gstAmount; // Update this line
                        ?>
                        <div class="box total-fare">
                            <div class="total-pass">Total Ticket Fare</div>
                            <div class="total-pass-number"><?php echo $totalfare ?><span class="gst">+ <?php echo $gstAmount ?>*(with GST)</span></div>
                        </div>
                    </div>
                </div>

                <div class="right">
                    <button type="submit" class="place-order" id="submitBtn">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Your HTML and PHP code -->
    <script>
       document.getElementById("submitBtn").addEventListener("click", reserveticket);

        function reserveticket() {

            $.ajax({
                type: 'POST',
                url: 'process_reservation.php',
                data: {
                    userid: '<?php echo $userid; ?>',
                    trainNumber: '<?php echo $trainNumber; ?>',
                    trainName: '<?php echo $trainName; ?>',
                    startPoint: '<?php echo $startPoint; ?>',
                    destinationPoint: '<?php echo $destinationPoint; ?>',
                    arrivalTime: '<?php echo $arrivalTime; ?>',
                    bookingDate: '<?php echo $JourneyDate; ?>',
                    Fare: '<?php echo $totalFare; ?>'
                },
                success: function(response) {
                    // Parse the JSON response and handle it accordingly
                    const responseData = JSON.parse(response);
                    if (responseData.status === 'success') {
                        // Reservation successful, take appropriate actions
                        console.log('Reservation successful');
                        alert('Reservation made');
                    } else {
                        // Reservation failed, handle error
                        console.error('Reservation failed');
                        alert('Reservation failed');
                    }
                }
            });

        }
    </script>

</body>

</html>