<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$trainCountResult = $mysqli->query("SELECT COUNT(*) as count FROM train_details");
$trainCount = $trainCountResult->fetch_assoc()['count'];

$passengerCountResult = $mysqli->query("SELECT COUNT(*) as count FROM passenger_details");
$passengerCount = $passengerCountResult->fetch_assoc()['count'];

$reservationCountResult = $mysqli->query("SELECT COUNT(*) as count FROM reservation_details");
$reservationCount = $reservationCountResult->fetch_assoc()['count'];

$accountingTotalResult = $mysqli->query("SELECT SUM(Fare) as total FROM reservation_details");
$accountingTotal = $accountingTotalResult->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>

  <style>
    .content_wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto;
    }

    .card {
      cursor: pointer;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem;
      height: 80px;
      border-radius: 30px;
      margin: 15px 0;
      background: rgba(255, 255, 255, 0.05);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(16.5px);
      -webkit-backdrop-filter: blur(16.5px);
      border-radius: 30px;
      border: 1px solid rgba(255, 255, 255, 0.18);
      margin: 15px;
      width: calc(25% - 30px);
      transition: transform 0.1s ease-in-out;
    }

    .card:hover {
      transform: scale(1.08);
    }

    .card1 {
      padding: 1.5rem;
    }

    .card2 {
      padding: 1rem 1.5rem;
    }

    .card3 {
      padding: 1.5rem;
    }

    .card4 {
      padding: 1.25rem 1.5rem;
    }

    .location {
      font-family: Poppins;
      font-style: normal;
      font-weight: 400;
      font-size: 16px;
      line-height: 22px;
      text-transform: capitalize;
      color: #000;

    }

    .degree {
      font-size: 28px;
      line-height: 10px;
      text-transform: capitalize;
      color: #23226B;
      font-family: 'Poppins', sans-serif;
    }

    .card-image img {
      width: 90px;
      height: 90px;
    }

    .pagination {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 20px 0;
    }

    .pagination a {
      display: inline-block;
      padding: 8px 12px;
      margin: 0 4px;
      border: 1px solid #ccc;
      text-decoration: none;
      color: #333;
      background-color: #fff;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    .pagination a:hover {
      background-color: #ddd;
    }

    .pagination .active {
      background-color: #007BFF;
      color: #fff;
    }
  </style>
</head>

<body>

  <?php include("assets/inc/navbar.php"); ?>

  <div class="content_wrapper">
    <div class="card 1st_card">
      <div class="card-content">
        <p class="location">Trains</p>
        <h1 class="degree"><?php echo $trainCount; ?></h1>

      </div>
      <div class="card-image">
        <img src="assets/img/trainlogo.png" alt="cloud" border="0">
      </div>
    </div>

    <div class="card 2nd_card">
      <div class="card-content">
        <p class="location">Passengers</p>
        <h1 class="degree"><?php echo $passengerCount; ?></h1>
      </div>
      <div class="card-image">
        <img src="assets/img/passengerlogo.png" alt="rain" border="0">
      </div>
    </div>

    <div class="card 3rd_card">
      <div class="card-content">
        <p class="location">Reservations</p>
        <h1 class="degree"><?php echo $reservationCount; ?></h1>
      </div>
      <div class="card-image">
        <img src="assets/img/reservelogo.png" alt="wind" border="0">
      </div>
    </div>

    <div class="card 4th_card">
      <div class="card-content">
        <p class="location">Accounting</p>
        <h1 class="degree"><?php echo $accountingTotal; ?></h1>
      </div>
      <div class="card-image">
        <img src="assets/img/accountlogo.png" alt="wind" border="0">
      </div>
    </div>
  </div>

  <?php
  $limit = 8;
  $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
  $offset = ($page - 1) * $limit;

  $ret = "SELECT * FROM train_details LIMIT ?, ?";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('ii', $offset, $limit);
  $stmt->execute();
  $res = $stmt->get_result();
  $cnt = 1;

  $total_rows = $mysqli->query("SELECT COUNT(*) as total FROM train_details")->fetch_assoc()['total'];
  $total_pages = ceil($total_rows / $limit);
  ?>

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
            <th>Train Number<span class="icon-arrow">&UpArrow;</span></th>
            <th>Train Name<span class="icon-arrow">&UpArrow;</span></th>
            <th>Station Name<span class="icon-arrow">&UpArrow;</span></th>
            <th>Start Station<span class="icon-arrow">&UpArrow;</span></th>
            <th>Destination Station<span class="icon-arrow">&UpArrow;</span></th>
            <th>Arrival Time<span class="icon-arrow">&UpArrow;</span></th>
            <th>Departure Time<span class="icon-arrow">&UpArrow;</span></th>
            <th>Distance<span class="icon-arrow">&UpArrow;</span></th>
            <th>Fare<span class="icon-arrow">&UpArrow;</span></th>
            <th>Seats<span class="icon-arrow">&UpArrow;</span></th>
          </tr>
        </thead>
        <tbody>
          <?php
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
            </tr>
          <?php
          } ?>
        </tbody>
      </table>
      <div class='pagination'>
        <?php
        if ($page > 1) {
          echo "<a href='emp-dashboard.php?page=" . ($page - 1) . "'>Previous</a>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
          echo "<a href='emp-dashboard.php?page=" . $i . "'>$i</a>";
        }
        if ($page < $total_pages) {
          echo "<a href='emp-dashboard.php?page=" . ($page + 1) . "'>Next</a>";
        }
        ?>
      </div>
    </section>
  </main>
</body>

</html>