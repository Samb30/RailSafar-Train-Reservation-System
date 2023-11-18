<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_GET['del'])) {
  $id = intval($_GET['del']);
  $adn = "delete from train_details where trainNumber=?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $succ = "Train Details Deleted";
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

    .btn.btn-primary.hide {
      opacity: 0;
      transform: translateX(100%);
      padding: 0;
      font: 0 / 0 sans-serif;
      transition: .2s ease-in-out .5s;
    }

    .btn.btn-primary:hover {
      background-color: #b4b4b433;
      color: #000;
    }
  </style>
</head>

<body>

  <?php include("assets/inc/navbar.php"); ?>

  <div>
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
        <h1>Train Details</h1>
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
              <th>Train Number</th>
              <th>Train Name</th>
              <th>Station Name</th>
              <th>Current Station</th>
              <th>Destination Station</th>
              <th>Arrival Time</th>
              <th>Departure Time</th>
              <th>Distance</th>
              <th>Fare</th>
              <th>Seats</th>
              <th></th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $ret = "SELECT * FROM train_details";
            $stmt = $mysqli->prepare($ret);
            $stmt->execute();
            $res = $stmt->get_result();
            $cnt = 1;
            while ($row = $res->fetch_object()) {
            ?>
              <tr>
                <td><?php echo $row->trainNumber; ?></td>
                <td><?php echo $row->trainName; ?></td>
                <td><?php echo $row->stationName; ?></td>
                <td><?php echo $row->startPoint; ?></td>
                <td><?php echo $row->destinationPoint; ?></td>
                <td><?php echo $row->arrivalTime; ?></td>
                <td><?php echo $row->departureTime; ?></td>
                <td><?php echo $row->distance; ?></td>
                <td><?php echo $row->Fare; ?></td>
                <td><?php echo $row->Seats; ?></td>
                <td>
                  <a class="btn btn-primary mb-3" href="emp-update-train.php?trainNumber=<?php echo $row->trainNumber; ?>">Update</a></td>
                <td><a class="btn btn-primary mb-3" href="emp-manage-train.php?del=<?php echo $row->trainNumber; ?>">Delete</a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </section>
    </main>
</body>

</html>