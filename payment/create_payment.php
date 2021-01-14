<?php session_start(); ?>

<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../condb/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

//สร้างตัวแปรสำหรับรับค่า retID จากไฟล์แสดงข้อมูล
$retID = $_REQUEST["id"];

$sql = "SELECT * FROM tbreturn JOIN tbcontract ON tbreturn.hirNum=tbcontract.hirNum JOIN tbcustomer ON tbcontract.cusCard=tbcustomer.cusCard JOIN tbuser ON tbcontract.usrID=tbuser.usrID JOIN tbtaxi ON tbcontract.carID=tbtaxi.carID WHERE retID='$retID'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);

$sql2 = "SELECT * FROM tbcompany";
$query2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($query2);

$sql3 = "SELECT MAX(id) as maxid from tbpayment";
$pay = mysqli_query($con, $sql3);
$data = mysqli_fetch_array($pay);

$date = date('Y');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>payment create</title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <!-- แจ้งเตือนสถานะ -->

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

    <div class="container">
        <br>
        <form action="save_payment.php" method="post">
            <div class="card text-dark">
                <div class="card-body" style="width: 100%;">
                    <div align="center" style="font-size: 22pt;"><img src="../images/company/<?php echo $row2['comLogo']; ?>" class="img-thumbnail" alt="customer" width="10%"></div>
                    <div align="center" style="font-size: 22pt; padding-top: 5px;"><b>ใบเสร็จรับเงิน</b></div>
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-4">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>ชื่อร้าน</b> <?php echo $row2['comName'] ?> </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-5">
                            <div align="left" style="font-size: 16pt;"><b>เลขที่ใบเสร็จ</b> PAY-<?php echo $date ?>-00<?php echo $data['maxid'] + 1 ?> </div>
                            <input type="hidden" name="payID" value="PAY-<?php echo $date ?>-00<?php echo $data['maxid'] + 1 ?>">
                            <input type="hidden" name="hirNum" value="<?php echo $row['hirNum'] ?>">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 3px;">
                        <div class="col-md-4">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>ชื่อผู้เช่า</b> <?php echo $row['cusName'] ?> </div>
                            <input type="hidden" name="cusCard" value="<?php echo $row['cusCard'] ?>">
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-5">
                            <div align="left" style="font-size: 16pt;"><b>พนักงานรับเงิน</b> <?php echo $_SESSION['usrName'] ?> </div>
                            <input type="hidden" name="usrID" value="<?php echo $_SESSION['usrID'] ?>">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 3px;">
                        <div class="col-md-4">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>วันที่เริ่มเช่า</b> <?php echo $row['hirStart'] ?> </div>
                            <input type="hidden" name="hirStart" value="<?php echo $row['hirStart'] ?>">
                        </div>
                        <div class="col-md-3">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>วันที่สิ้นสุด</b> <?php echo $row['hirEnd'] ?> </div>
                            <input type="hidden" name="hirEnd" value="<?php echo $row['hirEnd'] ?>">
                        </div>
                        <div class="col-md-5">
                            <div align="left" style="font-size: 16pt;"><b>จำนวนวัน</b> <?php echo $row['numDay'] ?> <b>วัน</b></div>
                            <input type="hidden" name="numDay" value="<?php echo $row['numDay'] ?>">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 15px;">
                        <div class="col-sm-8 border">
                            <div align="center" style="font-size: 14pt; padding-left: 10px;"><b>รายการ</b> </div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="center" style="font-size: 14pt; padding-left: 10px;"><b>ยอดเงิน</b></div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;"><b>รถแท็กซี่</b> <?php echo $row['carNum'] ?></div>
                            <input type="hidden" name="carID" value="<?php echo $row['carID'] ?>">
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['carRent'] ?> -.</div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">จำนวนวัน</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['numDay'] ?> วัน</div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">รวมค่าเช่า</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['hirTotal'] ?> -.</div>
                            <input type="hidden" name="totalhir" value="<?php echo $row['carRent'] * $row['numDay'] ?>">
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;"><u>หัก</u> ค่ามัดจำ 50%</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['hirDeposit'] ?> -.</div>
                            <input type="hidden" name="hirDeposit" value="<?php echo $row['hirDeposit'] ?>">
                        </div>
                    </div>
                    <div class="row" style="padding-top: 24px;">
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">ค้างชำระ</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['hirDeposit'] ?> -.</div>
                            <input type="hidden" name="balance_hirDeposit" value="<?php echo $row['hirDeposit'] ?>">
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">คืนช้าปรับวันละ 1000 <u>คืนช้า</u> <?php echo $row['dateRate'] ?> วัน</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['Fines'] ?> -.</div>
                            <input type="hidden" name="Fines" value="<?php echo $row['Fines'] ?>">
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">
                                <textarea id="text_rePair" name="text_rePair" rows="4" cols="50">**หากมีการซ่อมให้ระบุงานซ่อม พร้อมราคา 50%**</textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="center" style="font-size: 14pt;">
                                <input type="text" id="price_rePair" name="price_rePair" size="5" value="0">
                                <input type="hidden" id="repair" name="repair" value="">
                            </div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">ยอดชำระสุทธิ</div>
                        </div>
                        <div class="col-sm-4 border">
                            <input type="hidden" id="balance" name="balance" value="<?php echo $row['hirDeposit'] + $row['Fines'] ?>">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;" id="total">-.</b></div>
                            <input type="hidden" id="total2" name="total2" value="">
                        </div>
                    </div>
                    <br>
                    <div align="center" style="font-size: 12pt; padding-top: 5px;">ขอบคุณที่ใช้บริการ...</div>

                </div>
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-success">บันทึก</button>
                <!-- <button type="submit" class="btn btn-primary">พิมพ์</button> -->
            </div>
        </form>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            $("#price_rePair").change(function() {
                let price_rePair = $(this).val()
                let total = parseFloat(price_rePair) + parseFloat(balance);
                $("#total").html(total + " -.");
                $("#total2").val(total + " -.");
                if (price_rePair > 0) {
                    console.log("มีการซ่อมรถ")
                    $("#repair").val("มีการซ่อมรถ");
                } else {
                    console.log("ไม่มีการซ่อมรถ")
                    $("#repair").val("ไม่มีการซ่อมรถ");
                }
            });

            let price_rePair = $('#price_rePair').val();
            let balance = $('#balance').val();
            if (price_rePair < 1) {
                console.log("ไม่มีการซ่อมรถ");
                $("#repair").val("ไม่มีการซ่อมรถ");
            }
            console.log(price_rePair)
            console.log(balance)

            let total = parseFloat(price_rePair) + parseFloat(balance);
            console.log(total)
            $("#total").html(total + " -.");
            $("#total2").val(total);

        });
    </script>
</body>

</html>