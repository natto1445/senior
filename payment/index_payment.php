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
                    <h4><b>สัญญาที่ยังไม่ชำระเงิน</b>
                        <a class="text-secondary" style="float: right; padding-left: 15px" href="../return/create_return.php"><i class="fa fa-car" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../payment/index_payment.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h4>
                </div>
                <br>
                <div>
                    <?php
                    $query = "SELECT * FROM tbcontract  JOIN tbreturn ON tbcontract.hirNum = tbreturn.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbcontract.usrID = tbuser.usrID WHERE tbcontract.deliver='รอชำระเงิน' ORDER BY tbreturn.id DESC";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <table class="table-borderless">
                                    <tbody>
                                        <thead>
                                            <tr>
                                                <td style="width: 12%;"><b>เลขสัญญา</b></td>
                                                <td style="width: 13%;"><b>ชื่อผู้เช่า</b></td>
                                                <td style="padding-left: 10px; width: 18%;"><b>ทะเบียนรถ</b></td>
                                                <td style="padding-left: 10px;"><b>วันที่เริ่มเช่า</b></td>
                                                <td style="width: 13%; padding-left: 10px;"><b>วันที่คืนรถ</b></td>
                                                <td style="width: 10%; padding-left: 10px;"><b>ค่าปรับ</b></td>
                                                <td style="padding-left: 10px;"><b>ยอดสุทธิ</b></td>
                                                <td style="padding-left: 10px;"><b>สถานะ</b></td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td style="width: 12%;"><?php echo $row['hirNum']; ?></td>
                                            <td style="width: 13%;"><?php echo $row['cusName']; ?></td>
                                            <td style="padding-left: 10px; width: 18%;"><?php echo $row['carNum']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['hirStart']; ?></td>
                                            <td style="width: 13%; padding-left: 10px;"><?php echo $row['retDate']; ?></td>
                                            <td style="width: 10%; padding-left: 10px;"><?php echo $row['Fines']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['total']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $row['deliver']; ?></td>
                                            <td style="padding-left: 30px;"> <a class="btn btn-success" href="../payment/create_payment.php?id=<?php echo $row['retID']; ?>" onclick="return confirm('คุณต้องการชำระเงินสัญญาเช่า <?php echo $row['hirNum']; ?> ?')"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></a> </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                    <?php
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