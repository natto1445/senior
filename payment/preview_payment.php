<?php session_start(); ?>

<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../condb/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

//สร้างตัวแปรสำหรับรับค่า retID จากไฟล์แสดงข้อมูล
$retID = $_REQUEST["id"];

$sql2 = "SELECT * FROM tbcompany";
$query2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($query2);

$sql3 = "SELECT MAX(id) as maxid from tbpayment";
$pay = mysqli_query($con, $sql3);
$data = mysqli_fetch_array($pay);

$date = date('Y');
$date2 = date('d-m-Y')

?>

<?php
require_once __DIR__ . '../../vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '../tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);
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

    <?php if (isset($_SESSION['payID'])) :
        $payID = $_SESSION["payID"];
        $sql = "SELECT * FROM tbpayment JOIN tbcustomer ON tbpayment.cusCard=tbcustomer.cusCard JOIN tbcontract ON tbpayment.hirNum=tbcontract.hirNum JOIN tbreturn ON tbcontract.hirNum=tbreturn.hirNum JOIN tbtaxi ON tbpayment.carID=tbtaxi.carID WHERE tbpayment.payID = '$payID'";
        $query = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($query)) {
    ?>
            <?php
            ob_start();
            ?>
            <div class="container">
                <br>
                <div class="card text-dark">
                    <br>
                    <table align="center">
                        <tr>
                            <td colspan="2" style="font-size: 14pt;" align="right">วันที่ออกใบเสร็จ <?php echo $date2 ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 22pt; padding-top: 5px;" align="center"><img src="../images/company/<?php echo $row2['comLogo']; ?>" class="img-thumbnail" alt="customer" width="15%"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 22pt; padding-top: 10px;" align="center"><b>ใบเสร็จรับเงิน</b></td>
                        </tr>
                        <tr style="width: 100%;">
                            <td style="font-size: 16pt; padding-left: 10px;" width="70%"><b>ชื่อร้าน</b> <?php echo $row2['comName'] ?></td>
                            <td style="font-size: 16pt;" width="40%"><b>เลขที่ใบเสร็จ</b> <?php echo $payID ?></td>
                        </tr>
                        <tr style="width: 100%;">
                            <td style="font-size: 16pt; padding-left: 10px;" width="60%"><b>ชื่อผู้เช่า</b> <?php echo $row['cusName'] ?></td>
                            <td style="font-size: 16pt;" width="30%"><b>พนักงานรับเงิน</b> <?php echo $_SESSION['usrName'] ?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 16pt; padding-left: 10px;" width="60%"><b>วันที่เริ่มเช่า</b> <?php echo $row['hirStart'] ?></td>
                            <td style="font-size: 16pt;" width="30%"><b>วันที่สิ้นสุด</b> <?php echo $row['hirEnd'] ?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 16pt; padding-left: 10px;" width="60%"><b>จำนวนวัน</b> <?php echo $row['numDay'] ?> <b>วัน</b></td>
                            <td style="font-size: 16pt;" width="30%"></td>
                        </tr>
                    </table>
                    <br>
                    <table align="center" border="1">
                        <tr>
                            <th style="font-size: 14pt; text-align: center;" width="60px">ลำดับ</th>
                            <th style="font-size: 14pt; text-align: center;" width="320px">รายละเอียด</th>
                            <th style="font-size: 14pt; text-align: center;" width="210px">ราคา</th>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">1</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px"><b>รถแท็กซี่</b> <?php echo number_format($row['carNum']) ?></td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo $row['carRent'] ?> -.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">2</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px">รูปแบบการเช่า</td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo $row['hirPattern'] ?></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">3</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px">จำนวนวัน</td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo $row['numDay'] ?> วัน</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">4</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px">รวมค่าเช่า</td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo number_format($row['hirDeposit'] * 2) ?> -.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">5</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px"><u>หัก</u> ค่ามัดจำ 50%</td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo number_format($row['hirDeposit']) ?> -.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">6</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px">ค้างชำระ</td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo number_format($row['hirDeposit']) ?> -.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">7</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px">คืนช้าปรับวันละ 1,000 <u>คืนช้า</u> <?php echo $row['dateRate'] ?> วัน</td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo number_format($row['Fines']) ?> -.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">8</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px"><b>งานซ่อม</b> <?php if ($row['text_rePair'] == "**หากมีการซ่อมให้ระบุงานซ่อม**") {
                                                                                                                                echo "ไม่มีการซ่อมรถ";
                                                                                                                            } else {
                                                                                                                                echo $row['text_rePair'];
                                                                                                                            } ?></td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo number_format($row['price_rePair']) ?> -.</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">9</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px"></td>
                            <td style="font-size: 14pt; text-align: right; padding-right: 85px;" width="210px"><?php echo number_format($row['total2']) ?> -.</b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;" width="60px">10</td>
                            <td style="font-size: 14pt; text-align: left; padding-left: 30px;" width="320px">ยอดชำระสุทธิ</td>
                            <td style="font-size: 14pt; text-align: center;" width="210px"><?php echo convertAmountToLetter($row['total2']); ?>-.</b></td>
                        </tr>
                    </table>
                    <br>
                    <table align="center">
                        <tr>
                            <td colspan="2" style="font-size: 14pt; padding-top: 10px;" align="center"><b>ของคุณที่ใช้บริการ...</b></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td colspan="2" style="font-size: 14pt; padding-top: 10px; padding-left: 40px;" align="left"><b>ลงชื่อเจ้าของบริษัท</b> <u><?php echo $row2['comOwner']; ?></u></td>
                        </tr>
                    </table>
                    <br><br>
                </div>
                <?php
                $html = ob_get_contents();
                $mpdf->WriteHTML($html);
                $mpdf->Output("print_payment1.pdf");
                ob_end_flush();
                ?>
            </div>
            <br>
            <div class="container">
                <a class="btn btn-success" href="print_payment1.pdf"><i class="fa fa-print" aria-hidden="true"> Download </i></a>
            </div>
            <br>
    <?php
        }
    endif
    ?>
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