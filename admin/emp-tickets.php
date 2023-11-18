<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_GET['del'])) {
  $pnrNumber = $_GET['del'];
  $delete_query = "DELETE FROM reservation_details WHERE pnrNumber = ?";
  $stmt = $mysqli->prepare($delete_query);
  $stmt->bind_param('s', $pnrNumber);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $succ = "Reservation Details Deleted";
  } else {
    $err = "Try Again Later";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>

  <style>
    .btn.btn-primary {
      position: relative;
      color: #000;
      padding: 0.3rem 1rem;
      border-radius: 20px;
      border: 1px solid #ddd;
      background-color: inherit;
      box-shadow: none;
      overflow: hidden;
    }

    .btn.btn-primary:hover {
      background-color: #b4b4b433;
      color: #000;
    }
  </style>
</head>

<body>

  <?php include('assets/inc/navbar.php'); ?>

  <?php if (isset($succ)) { ?>

    <script>
      setTimeout(function() {
          swal("Success!", "<?php echo $succ; ?>!", "success");
        },
        100);
    </script>

  <?php } ?>
  <?php if (isset($err)) { ?>
    <script>
      setTimeout(function() {
          swal("Failed!", "<?php echo $err; ?>!", "Failed");
        },
        100);
    </script>

  <?php } ?>

  <main class="table">
    <section class="table__header">
      <h1>Reservation Details</h1>
      <div class="input-group">
        <input type="search" placeholder="Search Data...">
        <img src="assets/img/search.png" alt="">
      </div>
      <div class="export__file">
        <label for="export-file" class="export__file-btn" title="Export File"></label>
        <input type="checkbox" id="export-file">
        <div class="export__file-options">
          <label>Export As &nbsp; &#10140;</label>
          <label for="export-file" id="#toPDF">PDF <img src="assets/img/pdf.png" alt=""></label>
          <label for="export-file" id="toEXCEL">EXCEL <img src="assets/img/excel.png" alt=""></label>
        </div>
      </div>
    </section>
    <section class="table__body">
      <table>
        <thead>
          <tr>
            <th>Sr No.</th>
            <th>PNR Number</th>
            <th>Train Number</th>
            <th>Train Name</th>
            <th>Start Station</th>
            <th>Destination Station</th>
            <th>Booking Date</th>
            <th>No of Passengers</th>
            <th>Passengers</th>
            <th>Total Fare</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $ret = $ret = "SELECT r.pnrNumber, r.trainNumber, r.trainName, r.startPoint, r.destinationPoint, r.bookingDate, r.journeyDate, COUNT(p.passengerFname) AS passengerCount, GROUP_CONCAT(CONCAT(p.passengerFname, ' ', p.passengerLname)) AS passengers, r.Fare 
                              FROM reservation_details r
                              LEFT JOIN passenger_details p ON r.pnrNumber = p.pnrNumber
                              GROUP BY r.pnrNumber";
          $stmt = $mysqli->prepare($ret);
          $stmt->execute();
          $res = $stmt->get_result();
          $cnt = 1;
          while ($row = $res->fetch_object()) {
          ?>
            <tr>
              <td><?php echo $cnt++; ?></td>
              <td><?php echo $row->pnrNumber; ?></td>
              <td><?php echo $row->trainNumber; ?></td>
              <td><?php echo $row->trainName; ?></td>
              <td><?php echo $row->startPoint; ?></td>
              <td><?php echo $row->destinationPoint; ?></td>
              <td><?php echo $row->bookingDate; ?></td>
              <td><?php echo $row->passengerCount; ?></td>
              <td><?php echo str_replace("\n", '<br>', $row->passengers); ?></td>
              <td><?php echo $row->Fare; ?></td>
              <td><a class="btn btn-primary mb-3" href="emp-tickets.php?del=<?php echo $row->pnrNumber; ?>">Delete</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </main>

</body>

</html>