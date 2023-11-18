<?php 
 session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/pass-dashboard1.css" type="text/css" />
  <link rel="stylesheet" href="css/navbar.css" type="text/css" />

</head>

<body onload="myFunction()">
  <?php include 'navbar.php'; ?>

  <div class="below-search-area">
    <div class="container2">
      <div class="available-train">
        <h3>My Bookings</h3>
      </div>
      <div class="available-train-table">
        <table class="table">
          <thead>
            <tr>
              <th>PNR Number</th>
              <th>Train Number</th>
              <th>Train Name</th>
              <th>Train StartPoint</th>
              <th>Train DestinationPoint</th>
              <th>Train Arival Time</th>
              <th>Booking Date</th>
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
  <script>
    function myFunction() {
      
        var xhr = new XMLHttpRequest();

        // Define the PHP file to be called with query parameters
        var url = 'fetch_booking_data.php';

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
  </script>
</body>

</html>