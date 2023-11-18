<?php
session_start();

if (!isset($_SESSION['username'])) {
    exit('Not logged in');
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

// Establish connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalFare = $_POST['Fare'];
$trainNumber = $_POST['trainNumber'];
$trainName = $_POST['trainName'];
$startPoint = $_POST['startPoint'];
$destinationPoint = $_POST['destinationPoint'];
$arrivalTime = $_POST['arrivalTime'];
$JourneyDate = $_POST['bookingDate'];
$userid = $_POST['userid'];


$pnrNumber = rand(10, 100); // Generate a random PNR number between 10 and 100

// Check if the generated PNR number already exists in the database
$checkPnrNumberQuery = "SELECT COUNT(*) AS count FROM reservation_details WHERE pnrNumber = '$pnrNumber'";
$pnrNumberCheckResult = $conn->query($checkPnrNumberQuery);

if ($pnrNumberCheckResult->num_rows > 0) {
    $pnrNumberCheckRow = $pnrNumberCheckResult->fetch_assoc();
    $existingPnrNumberCount = $pnrNumberCheckRow['count'];

    // If the generated PNR number already exists, regenerate a new one
    if ($existingPnrNumberCount > 0) {
        $pnrNumber = rand(10, 100); // Generate a new random PNR number until it's unique
    }
}



$sql = "INSERT INTO reservation_details (pnrNumber, userId, trainNumber, trainName, startPoint, destinationPoint, arrivalTime, bookingDate, Fare)
             VALUES ($pnrNumber, '$userid', '$trainNumber', '$trainName', '$startPoint', '$destinationPoint', '$arrivalTime','$JourneyDate', '$totalFare')";

if ($conn->query($sql) === TRUE) {
    // Update passenger status to 'Booked' after reservation
    $updatePassengerStatus = "UPDATE passenger_details SET status = 'Booked' WHERE userId = '$userid'";
    if ($conn->query($updatePassengerStatus) === TRUE) {
        echo "console.log('Passenger status updated to Booked');";
    } else {
        echo "console.error('Error updating passenger status: " . $conn->error . "');";
    }
    echo "<script>alert('Reservation made');</script>";
    header("Location:succesfull.php");
} else {
    echo "console.error('Error inserting reservation details: " . $conn->error . "');";
}
$result = true; // Replace with your database operations and handling

if ($result) {
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'failure']);
  }

$conn->close();
