<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="homejs.js"></script>
  <link rel="stylesheet" href="styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,180;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,180;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
  <title>TravelByRails</title>
  <link rel="stylesheet" href="css/landing_page.css" type="text/css" />
</head>

<body>
  <nav>
    <div class="logo">
      <img src="assets1/logo.png" alt="Logo" />
    </div>
    <ul class="nav-links">
      <li><a href="pass-regi.php">Book Reservation</a></li>
      <li><a href="./admin/emp-login.php">Admin Login</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </nav>
  <div class="main">
    <div class="centered-container">
      <div class="text">
        <div class="maintext">Railway Adventure Awaits,
          <span>
            <div class="words">
              <span> Reserve Now</span>
              <span> Book Today</span>
              <span> Start Exploring</span>
              <span> Plan Your Journey</span>
              <span> Secure Your Seat</span>
            </div>
            <span>
        </div>
        <div class="normaltext">
          Travel by Rails is a platform that allows you to book train travels
          with ease and comfort.
        </div>
      </div>
      <div class="search-box">
        <div class="child firstchild">
          <div class="left firstchild">
            <img src="assets1/location.png" height="18" width="18" alt="">
          </div>
          <div class="right">
            <form REQUEST_METHOD="POST" action="">
              <input type="text" id="from" name="from" placeholder="From">
            </form>
          </div>
          <div class="right2">
            <img src="assets1/down.png" class="hoverdropdown" height="18" width="18" alt="">
            <div class="dropdown-content" id="station-dropdown">
            </div>
          </div>
        </div>
        <div class="child">
          <div class="left">
            <img src="assets1/location.png" height="18" width="18" alt="">
          </div>
          <div class="right">
            <form REQUEST_METHOD="POST" action="">
              <input type="text" id="from2" name="to" placeholder="To">
            </form>
          </div>
          <div class="right2">
            <img src="assets1/down.png" class="hoverdropdown2" height="18" width="18" alt="">
            <div class="dropdown-content" id="station-dropdown2">
            </div>
          </div>
        </div>

        <div class="child">
          <div class="left">
            <img src="assets1/calendar.png" height="18" width="18" alt="">
          </div>
          <div class="right">
            <input type="date" id="start" name="trip-start" value="" min="2022-01-01" max="2024-12-31" />
          </div>
        </div>

        <div class="child lastchild" id="redirect-regi">
          Search
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('redirect-regi').addEventListener('click', function() {
      window.location.href = "pass-regi.php"; // Replace with your desired URL
    });
  </script>

  <script>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbms";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    ?>
    document.addEventListener("DOMContentLoaded", function() {
      // Get references to the elements
      var dropdownIcon = document.querySelector(".hoverdropdown");
      var dropdownContent = document.getElementById("station-dropdown");
      var fromInput = document.getElementById("from"); // Reference to the input field

      // Add an event listener to show/hide the dropdown content
      dropdownIcon.addEventListener("click", function() {
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          // You can populate the station names dynamically here using PHP
          // For example, by fetching data from the database and generating HTML
          <?php
          // Step 2: Query the database for distinct station names and routes
          $query = "SELECT DISTINCT station_name FROM (
            SELECT startPoint AS station_name FROM train_details
            UNION
            SELECT destinationPoint AS station_name FROM train_details
        ) AS combined_stations";

          $result = $conn->query($query);

          if ($result->num_rows > 0) {
            echo 'dropdownContent.innerHTML = "";';
            while ($row = $result->fetch_assoc()) {
              echo 'dropdownContent.innerHTML += "<a href=\"#\">" + "' . $row['station_name'] . '" + "</a>";';
            }
          } else {
            echo 'dropdownContent.innerHTML = "<a href=\"#\">No stations found</a>";';
          }
          ?>
          dropdownContent.style.display = "block";
        }
      });

      // Add event listener to close the dropdown when clicking outside
      document.addEventListener("click", function(event) {
        if (event.target !== dropdownIcon && event.target !== dropdownContent) {
          dropdownContent.style.display = "none";
        }
      });

      // Add an event listener to get the selected value and populate the input field
      dropdownContent.addEventListener("click", function(event) {
        if (event.target.tagName === "A") {
          var selectedValue = event.target.textContent; // Get the text content of the clicked anchor element
          fromInput.value = selectedValue; // Set the input field's value
          dropdownContent.style.display = "none"; // Close the dropdown
        }
      });
    });



    document.addEventListener("DOMContentLoaded", function() {
      // Get references to the elements
      var dropdownIcon = document.querySelector(".hoverdropdown2");
      var dropdownContent = document.getElementById("station-dropdown2");
      var fromInput = document.getElementById("from2"); // Reference to the input field

      // Add an event listener to show/hide the dropdown content
      dropdownIcon.addEventListener("click", function() {
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          // You can populate the station names dynamically here using PHP
          // For example, by fetching data from the database and generating HTML
          <?php
          // Step 2: Query the database for distinct station names and routes
          $query = "SELECT DISTINCT station_name FROM (
            SELECT startPoint AS station_name FROM train_details
            UNION
            SELECT destinationPoint AS station_name FROM train_details
        ) AS combined_stations";

          $result = $conn->query($query);

          if ($result->num_rows > 0) {
            echo 'dropdownContent.innerHTML = "";';
            while ($row = $result->fetch_assoc()) {
              echo 'dropdownContent.innerHTML += "<a href=\"#\">" + "' . $row['station_name'] . '" + "</a>";';
            }
          } else {
            echo 'dropdownContent.innerHTML = "<a href=\"#\">No stations found</a>";';
          }
          ?>
          dropdownContent.style.display = "block";
        }
      });

      // Add event listener to close the dropdown when clicking outside
      document.addEventListener("click", function(event) {
        if (event.target !== dropdownIcon && event.target !== dropdownContent) {
          dropdownContent.style.display = "none";
        }
      });

      // Add an event listener to get the selected value and populate the input field
      dropdownContent.addEventListener("click", function(event) {
        if (event.target.tagName === "A") {
          var selectedValue = event.target.textContent; // Get the text content of the clicked anchor element
          fromInput.value = selectedValue; // Set the input field's value
          dropdownContent.style.display = "none"; // Close the dropdown
        }
      });
    });
  </script>
</body>

</html>