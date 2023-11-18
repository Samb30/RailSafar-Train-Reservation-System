<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

$conn = new mysqli($servername, $username, $password, $dbname);
$username = $_SESSION['username'];
// Retrieve POST data sent from AJAX request
$data = json_decode(file_get_contents("php://input"), true);

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

// Connect to your database
// Insert the received data into the reservation_details table using prepared statements
// Assuming you've already established a database connection $conn

// Prepare your INSERT query
$pnrNumber = rand(10, 100);

// Prepare your INSERT query
$stmt = $conn->prepare("INSERT INTO reservation_details (pnrNumber, userId,trainNumber, trainName,  startPoint, destinationPoint, arrivalTime, bookingDate, JourneyDate, totalFare) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters and execute the query
$stmt->bind_param("iiissssssi", $pnrNumber, $data['trainNumber'], $data['trainName'], $data['startPoint'], $data['destinationPoint'], $data['arrivalTime'], $data['bookingDate'], $data['JourneyDate'], $data['totalFare']);
$stmt->execute();

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>
