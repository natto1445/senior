<?php
include('../condb/condb.php');
$month = date('m');
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
    <link rel="stylesheet" type="text/css" href="bootstrap/css/dataTables.bootstrap4.min.css" />
    <script src="../js/sweetalert.min.js"></script>
    <style type="text/css">
        .center_div {
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <div style="width: 80%;" class="center_div">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h2><b>ข้อมูลสัญญาเช่า</b>
                        <a class="text-success" style="float: right; padding-left: 15px" href="../contract/create_contract.php"><i class="fa fa-file-o" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../contract/index_contract.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h2>
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

                    $query = "SELECT * FROM tbcontract  JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID WHERE tbcontract.hirDate >='2021-$month-01' AND tbcontract.hirDate<='2021-$month-31'  ORDER BY tbcontract.id DESC";
                    $result = mysqli_query($con, $query);


                    ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <table class="table-borderless" id="example">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; font-size: 16pt;"><b>เลขสัญญา</b></th>
                                        <th style="width: 12%; font-size: 16pt;"><b>ชื่อผู้เช่า</b></th>
                                        <th style="width: 10%; font-size: 16pt;"><b>วันที่ทำสัญญา</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt; width: 10%;"><b>วันที่เริ่ม</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt; width: 10%;"><b>วันที่สิ้นสุด</b></th>
                                        <th style="width: 12%; padding-left: 10px; font-size: 16pt;"><b>ชื่อพนักงาน</b></th>
                                        <th style="width: 15%; padding-left: 10px; font-size: 16pt;"><b>ทะเบียนรถ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt;"><b>ราคารถ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt; "><b>จำนวนวัน</b></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td style="width: 10%; font-size: 14pt; padding-top: 10px;"><?php echo $row['hirNum']; ?></td>
                                            <td style="width: 12%; font-size: 14pt; padding-top: 10px;"><?php echo $row['cusName']; ?></td>
                                            <td style="width: 10%; font-size: 14pt; padding-top: 10px;"><?php echo $row['hirDate']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; width: 10%; padding-top: 10px;"><?php echo $row['hirStart']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; width: 10%; padding-top: 10px;"><?php echo $row['hirEnd']; ?></td>
                                            <td style="width: 12%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['usrName']; ?></td>
                                            <td style="width: 15%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['carNum']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['carRent']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; text-align: center; padding-top: 10px;"><?php echo $row['numDay']; ?></td>
                                            <td style="padding-left: 30px; font-size: 14pt; padding-top: 10px;"> <a style="width: 70px;" class="btn btn-success" href="../contract/preview.php?id=<?php echo $row['hirNum']; ?>" onclick="return confirm('คุณต้องการพิมพ์สัญญาเช่า <?php echo $row['hirNum']; ?> ?')"><i style="font-size: 1.5rem;" class="fa fa-print" aria-hidden="true"></i></a> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <?php
                    mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="bootstrap/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>
<?php
include('../includes/scripts.php');
?>