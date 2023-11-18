<?php
session_start();

if (!isset($_SESSION['username'])) {
  // User is not logged in, redirect to the login page
  header("Location: pass-regi.php"); // Replace "login.php" with the actual login page URL

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/navbar.css" type="text/css" />
  <title>Document</title>
  <link rel="stylesheet" href="css/pass-dashboard1.css" type="text/css" />



</head>

<body>
  <div class="main">
    <div class="container">
      <?php include 'navbar.php'; ?>
      <div class="search-area">
        <div class="text-in-search">
          <h1>TRAVELLING MADE EASY</h1>
          <h3>Explore New places with the next generations E-ticketing System.</h3>
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

          <div class="child lastchild" onclick="myFunction()">
            Search
          </div>
        </div>

      </div>
      <div class="below-search-area">
        <div class="container2">
          <div class="available-train">
            <h3>Available Train</h3>
          </div>
          <div class="available-train-table">
            <table class="table">
              <thead>
                <tr>
                  <th>Train Number</th>
                  <th>Train Name</th>
                  <th>Train Station</th>
                  <th>Train StartPoint</th>
                  <th>Train DestinationPoint</th>
                  <th>Train Arival Time</th>
                  <th>Train Destination Time</th>
                  <th>Distance</th>
                  <th>Seats</th>
                  <th>Train Fare</th>
                  <th>Option</th>
                </tr>
              </thead>
              <tbody id="trainTableBody">

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function myFunction() {

      // Get the input values
      var fromValue = document.getElementById('from').value;
      var toValue = document.getElementById('from2').value;
      var dateValue = document.getElementById('start').value;

      if (!fromValue && !toValue) {
        alert("Please enter Destination and Source");
      } else if (!toValue) {
        alert("Please enter Destination");
      } else if (!fromValue) {
        alert("Please enter Source");
      } else {
        var xhr = new XMLHttpRequest();

        // Define the PHP file to be called with query parameters
        var url = 'fetch_train_data.php?from=' + encodeURIComponent(fromValue) + '&to=' + encodeURIComponent(toValue) + '&date=' + encodeURIComponent(dateValue);

        // Open a new GET request to the server
        xhr.open('GET', url, true);

        // Set up a callback function to handle the response
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            // Insert the response into the table body
            document.getElementById('trainTableBody').innerHTML = xhr.responseText;
          }
        };

        // Send the request to the server
        xhr.send();
      }
    }

    
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