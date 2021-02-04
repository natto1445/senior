<?php
include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>payment index</title>
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
                    <h2><b>สัญญาที่ยังไม่ชำระเงิน</b>
                        <a class="text-secondary" style="float: right; padding-left: 15px" href="../return/create_return.php"><i class="fa fa-car" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../payment/index_payment.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h2>
                </div>
                <br>
                <div>
                    <?php
                    $query = "SELECT * FROM tbcontract  JOIN tbreturn ON tbcontract.hirNum = tbreturn.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbcontract.usrID = tbuser.usrID WHERE tbcontract.deliver='รอชำระเงิน' ORDER BY tbreturn.id DESC";
                    $result = mysqli_query($con, $query);

                    ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <table class="table-borderless" id="example1">

                                <thead>
                                    <tr>
                                        <th style="width: 12%; font-size: 16pt;"><b>เลขสัญญา</b></th>
                                        <th style="width: 13%; font-size: 16pt;"><b>ชื่อผู้เช่า</b></th>
                                        <th style="padding-left: 10px; width: 14%; font-size: 16pt;"><b>ทะเบียนรถ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt; width: 10%;"><b>วันที่เริ่มเช่า</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt; width: 10%;"><b>วันที่สิ้นสุด</b></th>
                                        <th style="width: 10%; padding-left: 10px; font-size: 16pt;"><b>วันที่คืนรถ</b></th>
                                        <th style="width: 10%; padding-left: 10px; font-size: 16pt;"><b>ค่าปรับ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt;"><b>ยอดสุทธิ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt;"><b>สถานะ</b></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td style="width: 12%; font-size: 14pt; padding-top: 10px;"><?php echo $row['hirNum']; ?></td>
                                            <td style="width: 13%; font-size: 14pt; padding-top: 10px;"><?php echo $row['cusName']; ?></td>
                                            <td style="padding-left: 10px; width: 14%; font-size: 14pt; padding-top: 10px;"><?php echo $row['carNum']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px; width: 10%;"><?php echo $row['hirStart']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px; width: 10%;"><?php echo $row['hirEnd']; ?></td>
                                            <td style="width: 10%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['retDate']; ?></td>
                                            <td style="width: 10%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['Fines']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['total']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $row['deliver']; ?></td>
                                            <td style="padding-left: 30px; font-size: 14pt; padding-top: 10px;"> <a style="width: 70px;" class="btn btn-success" href="../payment/create_payment.php?id=<?php echo $row['retID']; ?>" onclick="return confirm('คุณต้องการชำระเงินสัญญาเช่า <?php echo $row['hirNum']; ?> ?')"><i style="font-size: 1.5rem;" class="fa fa-credit-card-alt" aria-hidden="true"></i></a> </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h2>
                        <b>สัญญาที่ชำระแล้ว</b>
                    </h2>
                </div>
                <br>
                <div>
                    <?php

                    $sql = "SELECT * FROM tbcontract  JOIN tbreturn ON tbcontract.hirNum = tbreturn.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbcontract.usrID = tbuser.usrID JOIN tbpayment ON tbpayment.hirNum=tbcontract.hirNum WHERE tbcontract.deliver='ชำระแล้ว' ORDER BY tbreturn.id DESC";
                    $result_sql = mysqli_query($con, $sql);
                    ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <table class="table-borderless" id="example">
                                <thead>
                                    <tr>
                                        <th style="width: 10%; font-size: 16pt;"><b>เลขที่ชำระ</b></th>
                                        <th style="width: 10%; font-size: 16pt;"><b>เลขสัญญา</b></th>
                                        <th style="width: 13%; font-size: 16pt;"><b>ชื่อผู้เช่า</b></th>
                                        <th style="padding-left: 10px; width: 12%; font-size: 16pt;"><b>ทะเบียนรถ</b></th>
                                        <!-- <th style="padding-left: 10px;"><b>วันที่เริ่มเช่า</b></th> -->
                                        <th style="width: 8%; padding-left: 10px; font-size: 16pt;"><b>วันที่เริ่มเช่า</b></th>
                                        <th style="width: 8%; padding-left: 10px; font-size: 16pt;"><b>วันที่สิ้นสุด</b></th>
                                        <th style="width: 10%; padding-left: 10px; font-size: 16pt;"><b>วันที่คืนรถ</b></th>
                                        <th style="width: 6%; padding-left: 10px; font-size: 16pt;"><b>ค่าปรับ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt;"><b>ยอดสุทธิ</b></th>
                                        <th style="padding-left: 10px; font-size: 16pt;"><b>สถานะ</b></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($data = mysqli_fetch_array($result_sql)) {
                                    ?>
                                        <tr>
                                            <td style="width: 10%; font-size: 14pt; padding-top: 10px;"><?php echo $data['payID']; ?></td>
                                            <td style="width: 10%; font-size: 14pt; padding-top: 10px;"><?php echo $data['hirNum']; ?></td>
                                            <td style="width: 13%; font-size: 14pt; padding-top: 10px;"><?php echo $data['cusName']; ?></td>
                                            <td style="padding-left: 10px; width: 12%; font-size: 14pt; padding-top: 10px;"><?php echo $data['carNum']; ?></td>
                                            <!-- <td style="padding-left: 10px;"><?php //echo $data['hirStart']; 
                                                                                    ?></td> -->
                                            <td style="width: 8%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $data['hirStart']; ?></td>                                        
                                            <td style="width: 8%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $data['hirEnd']; ?></td>                                        
                                            <td style="width: 10%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $data['retDate']; ?></td>
                                            <td style="width: 6%; padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $data['Fines']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $data['total']; ?></td>
                                            <td style="padding-left: 10px; font-size: 14pt; padding-top: 10px;"><?php echo $data['deliver']; ?></td>
                                            <td style="padding-left: 30px; font-size: 14pt; padding-top: 10px;"> <a style="width: 70px;" class="btn btn-success" href="../payment/print_payment.php?id=<?php echo $data['payID']; ?>" onclick="return confirm('คุณต้องการพิมพ์ใบเสร็จ <?php echo $data['payID']; ?> อีกครั้งใช่ไหม ?')"><i style="font-size: 1.5rem;" class="fa fa-file-text-o" aria-hidden="true"></i></a> </td>
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
        $(document).ready(function() {
            $('#example1').DataTable();
        });
    </script>
</body>

</html>
<?php
include('../includes/scripts.php');
?>