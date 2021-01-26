<?php
include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>contract index</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../js/sweetalert.min.js"></script>
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <div class="container">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h4><b>ข้อมูลสัญญาเช่า</b>
                        <a class="text-success" style="float: right; padding-left: 15px" href="../contract/create_contract.php"><i class="fa fa-file-o" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../contract/index_contract.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h4>
                </div>
                <br>
                <?php if (isset($_SESSION["save_contract_msg"])) : ?>
                    <script>
                        swal({
                            title: "<?php echo $_SESSION['save_contract_msg']; ?>",
                            icon: "<?php echo $_SESSION['save_contract_msg1']; ?>",
                            button: "OK",
                        });
                    </script>
                    <?php unset($_SESSION['save_contract_msg']); ?>
                <?php endif ?>

                <?php if (isset($_SESSION['status'])) : ?>
                    <script>
                        swal({
                            title: "<?php echo $_SESSION['status']; ?>",
                            icon: "<?php echo $_SESSION['status_code']; ?>",
                            button: "OK",
                        });
                    </script>
                    <?php unset($_SESSION['status']); ?>
                <?php endif ?>
                <div>
                    <?php
                    $limit = 4;  //set  Number of entries to show in a page.
                    // Look for a GET variable page if not found default is 1.        
                    if (isset($_GET["page"])) {
                        $page  = $_GET["page"];
                    } else {
                        $page = 1;
                    }
                    //determine the sql LIMIT starting number for the results on the displaying page  
                    $page_index = ($page - 1) * $limit;      // 0

                    $query = "SELECT * FROM tbcontract  JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID ORDER BY tbcontract.id DESC LIMIT $page_index, $limit";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <table class="table-borderless">
                                    <tbody>
                                        <thead>
                                            <tr>
                                                <td style="width: 13%;"><b>เลขสัญญา</b></td>
                                                <td style="width: 15%;"><b>ชื่อผู้เช่า</b></td>
                                                <td style="padding-left: 10px;"><b>วันที่เริ่ม</b></td>
                                                <td style="padding-left: 10px;"><b>วันที่สิ้นสุด</b></td>
                                                <td style="width: 15%; padding-left: 10px;"><b>ชื่อพนักงาน</b></td>
                                                <td style="width: 15%; padding-left: 10px;"><b>ทะเบียนรถ</b></td>
                                                <td style="padding-left: 10px;"><b>ราคารถ</b></td>
                                                <td style="padding-left: 10px;"><b>จำนวนวัน</b></td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td style="width: 13%;"><?php echo $row['hirNum']; ?></td>
                                            <td style="width: 15%;"><?php echo $row['cusName']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['hirStart']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['hirEnd']; ?></td>
                                            <td style="width: 15%; padding-left: 10px;"><?php echo $row['usrName']; ?></td>
                                            <td style="width: 15%; padding-left: 10px;"><?php echo $row['carNum']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['carRent']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['numDay']; ?></td>
                                            <td style="padding-left: 30px;"> <a class="btn btn-success" href="../contract/preview.php?id=<?php echo $row['hirNum']; ?>" onclick="return confirm('คุณต้องการพิมพ์สัญญาเช่า <?php echo $row['hirNum']; ?> ?')"><i class="fa fa-print" aria-hidden="true"></i></a> </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                    <?php
                    }
                    $all_data = mysqli_query($con, "select count(*) from tbcontract");
                    $user_count = mysqli_fetch_row($all_data);
                    $total_records = $user_count[0];
                    $total_pages = ceil($total_records / $limit);
                    if ($page >= 2) {
                        echo "<a href='index_contract.php?page=" . ($page - 1) . "' class='btn customBtn2'>ย้อนหลับ</a>";
                    }

                    if ($page < $total_pages) {
                        echo "<a href='index_contract.php?page=" . ($page + 1) . "' class='btn customBtn2'>ถัดไป</a>";
                    }

                    mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
include('../includes/scripts.php');
?>