<?php session_start(); ?>

<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../condb/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

//สร้างตัวแปรสำหรับรับค่า retID จากไฟล์แสดงข้อมูล
$payID = $_REQUEST["id"];

$sql = "SELECT * FROM tbpayment JOIN tbtaxi ON tbpayment.carID=tbtaxi.carID JOIN tbcustomer ON tbpayment.cusCard=tbcustomer.cusCard JOIN tbreturn ON tbpayment.hirNum=tbreturn.hirNum WHERE tbpayment.payID='$payID'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);
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
                            <div align="left" style="font-size: 16pt;"><b>เลขที่ใบเสร็จ</b> <?php echo $payID ?> </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 3px;">
                        <div class="col-md-4">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>ชื่อผู้เช่า</b> <?php echo $row['cusName'] ?> </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-5">
                            <div align="left" style="font-size: 16pt;"><b>พนักงานรับเงิน</b> <?php echo $_SESSION['usrName'] ?> </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 3px;">
                        <div class="col-md-4">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>วันที่เริ่มเช่า</b> <?php echo $row['hirStart'] ?> </div>
                        </div>
                        <div class="col-md-3">
                            <div style="font-size: 16pt; padding-left: 10px;"><b>วันที่สิ้นสุด</b> <?php echo $row['hirEnd'] ?> </div>
                        </div>
                        <div class="col-md-5">
                            <div align="left" style="font-size: 16pt;"><b>จำนวนวัน</b> <?php echo $row['numDay'] ?> <b>วัน</b></div>
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
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['hirDeposit'] * 2 ?> -.</div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;"><u>หัก</u> ค่ามัดจำ 50%</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['hirDeposit'] ?> -.</div>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 24px;">
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">ค้างชำระ</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['hirDeposit'] ?> -.</div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">คืนช้าปรับวันละ 1000 <u>คืนช้า</u> <?php echo $row['dateRate'] ?> วัน</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['Fines'] ?> -.</div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">
                                <textarea id="text_rePair" name="text_rePair" rows="4" cols="50" readonly><?php if ($row['text_rePair'] == "**หากมีการซ่อมให้ระบุงานซ่อม**") {
                                                                                                        echo "ไม่มีการซ่อมรถ";
                                                                                                    } else {
                                                                                                        echo $row['text_rePair'];
                                                                                                    } ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt;">
                                <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['price_rePair'] ?> -.</div>
                            </div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;"></div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 110px;"><?php echo $row['total2'] ?> -.</b></div>
                        </div>
                        <div class="col-sm-8 border">
                            <div align="left" style="font-size: 14pt; padding-left: 150px;">ยอดชำระสุทธิ</div>
                        </div>
                        <div class="col-sm-4 border">
                            <div align="right" style="font-size: 14pt; padding-right: 50px;"><?php echo convertAmountToLetter($row['total2']); ?>-.</b></div>
                        </div>
                    </div>
                    <br>
                    <div align="center" style="font-size: 12pt; padding-top: 5px;">ขอบคุณที่ใช้บริการ...</div>

                </div>
            </div>
            <br>
            <div>
                <button type="submit" class="btn btn-success">พิมพ์</button>
                <!-- <button type="submit" class="btn btn-primary">พิมพ์</button> -->
            </div>
        </form>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            $("#price_rePair100").change(function() {
                let price_rePai0r100 = $(this).val()
                let price_rePair = price_rePai0r100 / 2
                $("#price_rePair").val(price_rePair);
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

<?php
function convertAmountToLetter($number)
{
    if (empty($number)) return "";
    $number = strval($number);
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return '';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) && $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == ($strlen - 2) && $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) && $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }
    $convert .= 'บาท';
    if (sizeof($number) == 1) {
        $convert .= 'ถ้วน';
    } else {
        if ($number[1] == '0' || $number[1] == '00' || $number[1] == '') {
            $convert .= 'ถ้วน';
        } else {
            $number[1] = substr($number[1], 0, 2);
            $strlen = strlen($number[1]);
            for ($i = 0; $i < $strlen; $i++) {
                $n = substr($number[1], $i, 1);
                if ($n != 0) {
                    if ($i > 0 && $n == 1) {
                        $convert .= 'เอ็ด';
                    } elseif ($i == 0 && $n == 2) {
                        $convert .= 'ยี่';
                    } elseif ($i == 0 && $n == 1) {
                        $convert .= '';
                    } else {
                        $convert .= $txtnum1[$n];
                    }
                    $convert .= $i == 0 ? $txtnum2[1] : '';
                }
            }
            $convert .= 'สตางค์';
        }
    }
    return $convert . PHP_EOL;
}
?>