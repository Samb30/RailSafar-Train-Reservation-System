<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_GET['del'])) {
  $id = intval($_GET['del']);
  $adn = "delete from passenger_details where passengerId=?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $succ = "Pasenger Details Removed";
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
      <h1>Passenger Details</h1>
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
            <th>Id</th>
            <th>PNR Number</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Train Name</th>
            <th>Train Number</th>
            <th>Destination Station</th>
            <th>Date of Journey</th>
            <th>Fare</th>
            <th></th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $ret = "SELECT pd.userId, pd.passengerId, pd.passengerFname, pd.passengerLname, pd.passengerAge, pd.passengerGender, pd.passengerAddress, rd.trainName, rd.trainNumber, rd.destinationPoint,  rd.journeyDate, td.Fare as trainFare
                  FROM reservation_details rd
                  INNER JOIN passenger_details pd ON rd.userId = pd.userId
                  INNER JOIN train_details td ON rd.trainNumber = td.trainNumber
                  WHERE rd.trainName IS NOT NULL";
          $stmt = $mysqli->prepare($ret);
          $stmt->execute();
          $res = $stmt->get_result();
          $cnt = 1;
          while ($row = $res->fetch_object()) {
          ?>
            <tr>
              <td><?php echo $row->passengerId; ?></td>
              <td><?php echo $row->userId; ?></td>
              <td><?php echo $row->passengerFname . ' ' . $row->passengerLname; ?></td>
              <td><?php echo $row->passengerAge; ?></td>
              <td><?php echo $row->passengerGender; ?></td>
              <td><?php echo $row->passengerAddress; ?></td>
              <td><?php echo $row->trainName; ?></td>
              <td><?php echo $row->trainNumber; ?></td>
              <td><?php echo $row->destinationPoint; ?></td>
              <td><?php echo $row->journeyDate; ?></td>
              <td><?php echo $row->trainFare; ?></td>
              <td><a class="btn btn-primary mb-3" href="emp-update-passenger.php?passengerId=<?php echo $row->passengerId; ?>">Update</a></td>
              <td><a class="btn btn-primary mb-3" href="emp-manage-passengers.php?del=<?php echo $row->passengerId; ?>">Delete</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
  </main>

</body>

</html>