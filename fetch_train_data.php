<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$fromValue = $_GET['from'];
$toValue = $_GET['to'];
$dateValue = $_GET['date'];

// Using prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM train_details WHERE startPoint = ? AND destinationPoint = ? ORDER BY RAND() LIMIT 50");
$stmt->bind_param("ss", $fromValue, $toValue);

if ($stmt->execute()) {
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
      echo "<tr class='odd gradeX even gradeC odd gradeA'>";
      echo "<td>" . $row->trainNumber . "</td>";
      echo "<td>" . $row->trainName . "</td>";
      echo "<td>" . $row->stationName . "</td>";
      echo "<td>" . $row->startPoint . "</td>";
      echo "<td>" . $row->destinationPoint . "</td>";
      echo "<td>" . $row->arrivalTime . "</td>";
      echo "<td>" . $row->departureTime . "</td>";
      echo "<td>" . $row->distance . "</td>";
      echo "<td>" . $row->Seats . "</td>";
      echo "<td>" . $row->Fare . "</td>";
      echo "<td><a href='book_ticket.php?train_number=" . $row->trainNumber . "&train_name=" . urlencode($row->trainName) . "&train_station=" . urlencode($row->stationName) . "&train_startPoint=" . urlencode($row->startPoint) . "&destinationPoint=" . urlencode($row->destinationPoint) . "&arrivalTime=" . urlencode($row->arrivalTime) . "&train_fare=" . urlencode($row->Fare) . "&departureTime=" . urlencode($row->departureTime) . "&distance=" . urlencode($row->distance) . "&Seats=" . urlencode($row->Seats) . "&JourneyDate=" . urlencode($dateValue) . "' class=\"button three rounded\">Book</a></td>";
      echo "</tr>";
    }
  } else {
    echo nl2br("<span style='color:red;'>No Data Found!\nAvailable Trains.</span>");
    // Close the previous statement
    $stmt->close();

    // Perform a new query to get all available trains
    $allTrainsQuery = "SELECT * FROM train_details";
    $allTrainsResult = $conn->query($allTrainsQuery);

    if ($allTrainsResult) {
      while ($row = $allTrainsResult->fetch_object()) {
        echo "<tr class='odd gradeX even gradeC odd gradeA'>";
        echo "<td>" . $row->trainNumber . "</td>";
        echo "<td>" . $row->trainName . "</td>";
        echo "<td>" . $row->stationName . "</td>";
        echo "<td>" . $row->startPoint . "</td>";
        echo "<td>" . $row->destinationPoint . "</td>";
        echo "<td>" . $row->arrivalTime . "</td>";
        echo "<td>" . $row->departureTime . "</td>";
        echo "<td>" . $row->distance . "</td>";
        echo "<td>" . $row->Seats . "</td>";
        echo "<td>" . $row->Fare . "</td>";
        echo "<td><a href='book_ticket.php?train_number=" . $row->trainNumber . "&train_name=" . urlencode($row->trainName) . "&train_station=" . urlencode($row->stationName) . "&train_startPoint=" . urlencode($row->startPoint) . "&destinationPoint=" . urlencode($row->destinationPoint) . "&arrivalTime=" . urlencode($row->arrivalTime) . "&train_fare=" . urlencode($row->Fare) . "&departureTime=" . urlencode($row->departureTime) . "&distance=" . urlencode($row->distance) . "&Seats=" . urlencode($row->Seats) . "&JourneyDate=" . urlencode($dateValue) . "' class=\"button three rounded\">Book</a></td>";
        echo "</tr>";
      }
    } else {
      echo "Error loading all available trains: " . $conn->error;
    }
  }
} else {
  echo "Error executing the query: " . $stmt->error;
}

$conn->close();

