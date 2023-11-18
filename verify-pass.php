<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$enteredPassword = $_GET['enteredPassword'];

$username = $_SESSION['username'];

$sql = "SELECT userPwd FROM users_details WHERE userUname = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Get the password from the result
    $userPassword = $row['userPwd'];

    // Check if the entered password matches the user's original password
    if ($enteredPassword == $userPassword) {
        // Passwords match
        echo "success";
    } else {
        // Passwords do not match
        echo "failure";
    }
} else {
    echo "User not found in the databas e.";
}


// Prepare a SQL statement to retrieve the password for the user


// Close the database connection
$conn->close();
