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


// Using prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM reservation_details ");

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            echo "<tr class='odd gradeX even gradeC odd gradeA'>";
            echo "<td>" . $row->pnrNumber . "</td>";
            echo "<td>" . $row->trainNumber . "</td>";
            echo "<td>" . $row->trainName . "</td>";
            echo "<td>" . $row->startPoint . "</td>";
            echo "<td>" . $row->destinationPoint . "</td>";
            echo "<td>" . $row->arrivalTime . "</td>";
            echo "<td>" . $row->bookingDate . "</td>";
            echo "<td>" . $row->Fare . "</td>";
            echo "<td><a href='pass-print-ticket.php?pnrNumber=" . $row->pnrNumber . "&trainNumber=" . $row->trainNumber . "&trainName=".$row->trainName."&startPoint=".$row->startPoint."&destinationPoint=".$row->destinationPoint."&arrivalTime=".$row->arrivalTime."&bookingDate=".$row->bookingDate."&Fare=".$row->Fare."' class=\"button three rounded\">Print</a></td>";
            echo "</tr>";
        }
    }
} else {
    echo "Error executing the query: " . $stmt->error;
}

$conn->close();
