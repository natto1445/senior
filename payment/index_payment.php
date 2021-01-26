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
                    //mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h4>
                        <b>สัญญาที่ชำระแล้ว</b>
                    </h4>
                </div>
                <br>
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

                    $sql = "SELECT * FROM tbcontract  JOIN tbreturn ON tbcontract.hirNum = tbreturn.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbcontract.usrID = tbuser.usrID JOIN tbpayment ON tbpayment.hirNum=tbcontract.hirNum WHERE tbcontract.deliver='ชำระแล้ว' ORDER BY tbreturn.id DESC LIMIT $page_index, $limit";
                    $result_sql = mysqli_query($con, $sql);

                    while ($data = mysqli_fetch_array($result_sql)) {
                    ?>
                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <table class="table-borderless">
                                    <tbody>
                                        <thead>
                                            <tr>
                                                <td style="width: 12%;"><b>เลขที่ชำระ</b></td>
                                                <td style="width: 12%;"><b>เลขสัญญา</b></td>
                                                <td style="width: 13%;"><b>ชื่อผู้เช่า</b></td>
                                                <td style="padding-left: 10px; width: 15%;"><b>ทะเบียนรถ</b></td>
                                                <td style="padding-left: 10px;"><b>วันที่เริ่มเช่า</b></td>
                                                <td style="width: 10%; padding-left: 10px;"><b>วันที่คืนรถ</b></td>
                                                <td style="width: 8%; padding-left: 10px;"><b>ค่าปรับ</b></td>
                                                <td style="padding-left: 10px;"><b>ยอดสุทธิ</b></td>
                                                <td style="padding-left: 10px;"><b>สถานะ</b></td>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td style="width: 12%;"><?php echo $data['payID']; ?></td>
                                            <td style="width: 12%;"><?php echo $data['hirNum']; ?></td>
                                            <td style="width: 13%;"><?php echo $data['cusName']; ?></td>
                                            <td style="padding-left: 10px; width: 15%;"><?php echo $data['carNum']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $data['hirStart']; ?></td>
                                            <td style="width: 10%; padding-left: 10px;"><?php echo $data['retDate']; ?></td>
                                            <td style="width: 8%; padding-left: 10px;"><?php echo $data['Fines']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $data['total']; ?></td>
                                            <td style="padding-left: 10px;"><?php echo $data['deliver']; ?></td>
                                            <td style="padding-left: 30px;"> <a class="btn btn-success" href="../payment/print_payment.php?id=<?php echo $data['payID']; ?>" onclick="return confirm('คุณต้องการพิมพ์ใบเสร็จ <?php echo $data['payID']; ?> อีกครั้งใช่ไหม ?')"><i class="fa fa-file-text-o" aria-hidden="true"></i></a> </td>
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
                        echo "<a href='index_payment.php?page=" . ($page - 1) . "' class='btn customBtn2'>ย้อนหลับ</a>";
                    }

                    if ($page < $total_pages) {
                        echo "<a href='index_payment.php?page=" . ($page + 1) . "' class='btn customBtn2'>ถัดไป</a>";
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