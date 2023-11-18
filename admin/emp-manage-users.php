<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "delete from users_details where userId=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $succ = "User Details Removed";
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
            <h1>User Details</h1>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="assets/img/search.png" alt="">
            </div>
            <div class="export__file">
                <label for="export-file" class="export__file-btn" title="Export File"></label>
                <input type="checkbox" id="export-file">
                <div class="export__file-options">
                    <label>Export As &nbsp; &#10140;</label>
                    <label for="export-file" id="toPDF">PDF <img src="assets/img/pdf.png" alt=""></label>
                    <label for="export-file" id="toEXCEL">EXCEL <img src="assets/img/excel.png" alt=""></label>
                </div>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Sr. No.<span class="icon-arrow">&UpArrow;</span></th>
                        <th>Name<span class="icon-arrow">&UpArrow;</span></th>
                        <th>Phone No<span class="icon-arrow">&UpArrow;</span></th>
                        <th>Email<span class="icon-arrow">&UpArrow;</span></th>
                        <th>Username<span class="icon-arrow">&UpArrow;</span></th>
                        <th>Address<span class="icon-arrow">&UpArrow;</span></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ret = "SELECT * FROM users_details";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                    ?>
                        <tr>
                            <td><?php echo $cnt++; ?></td>
                            <td><?php echo $row->userFname . ' ' . $row->userLname; ?></td>
                            <td><?php echo $row->userPhone; ?></td>
                            <td><?php echo $row->userEmail; ?></td>
                            <td><?php echo $row->userUname; ?></td>
                            <td><?php echo $row->userAddr; ?></td>
                            <td><a class="btn btn-primary mb-3" href="emp-update-users.php?userId=<?php echo $row->userId; ?>">Update</a>
                                <a class="btn btn-primary mb-3" href="emp-manage-users.php?del=<?php echo $row->userId; ?>">Delete</a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>