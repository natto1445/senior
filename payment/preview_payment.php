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
        $sql = "SELECT * FROM tbpayment JOIN tbcontract ON tbpayment.hirNum=tbcontract.hirNum JOIN tbreturn ON tbcontract.hirNum=tbreturn.hirNum JOIN tbtaxi ON tbpayment.carID=tbtaxi.carID WHERE tbpayment.payID = '$payID'";
        $query = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($query)) {
    ?>
            <div class="container">
                <div class="col-12 container">

                    <div id="div_print">

                        <table width="97%" border="0" cellspacing="0" cellpadding="0" align="center" style='font-size:16.0pt; font-family:"TH SarabunPSK",sans-serif'>
                            <tbody>
                                <tr>
                                    <td>&nbsp;<br><br><br></td>
                                    <td width="30%" rowspan="2" align="center"><img width="50%" src="../images/company/<?php echo $row2['comLogo']; ?>" alt="logo" style="padding-top: 1px"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" style="padding-top: 50px;"><br>
                                        <h3><b>ใบเสร็จรับเงิน</b></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">&emsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style='font-size:16.0pt; font-family:"TH SarabunPSK",sans-serif'>
                                            <thead>
                                                <tr align="left">
                                                    <th width="10%" style="vertical-align: middle;"></th>
                                                    <th width="35%" style="vertical-align: middle;"><?php echo $row2['comName'] ?></th>
                                                    <th width="10%" style="vertical-align: middle;"><b></b></th>
                                                    <th width="35%" style="vertical-align: middle;"><b>เลขที่ใบเสร็จ</b> <?php echo $payID ?> </th>
                                                    <th width="10%" style="vertical-align: middle;"><b></b></th>
                                                </tr>
                                                <tr align="left">
                                                    <th width="10%" style="vertical-align: middle;"></th>
                                                    <th width="35%" style="vertical-align: middle; padding-top: 7px;"><b>ชื่อผู้เช่า</b> <?php echo $row['cusCard'] ?></th>
                                                    <th width="10%" style="vertical-align: middle;"><b></b></th>
                                                    <th width="35%" style="vertical-align: middle;"><b>พนักงานรับเงิน</b> <?php echo $row['usrID'] ?></th>
                                                    <th width="10%" style="vertical-align: middle;"><b></b></th>
                                                </tr>
                                                <tr align="left">
                                                    <th width="10%" style="vertical-align: middle;"></th>
                                                    <th width="35%" style="vertical-align: middle; padding-top: 7px;"><b>วันที่เริ่มเช่า</b> <?php echo $row['hirStart'] ?></th>
                                                    <th width="10%" style="vertical-align: middle;"><b></b></th>
                                                    <th width="35%" style="vertical-align: middle;"><b>วันที่สิ้นสุด</b> <?php echo $row['hirEnd'] ?></th>
                                                    <th width="10%" style="vertical-align: middle;"><b></b></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 30px;"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">
                                        <table border="1" cellpadding="0" cellspacing="0" width="80%" style='font-size:16.0pt; font-family:"TH SarabunPSK",sans-serif'>
                                            <tbody>
                                                <hr style="width: 80%;">
                                                <hr style="width: 80%;">
                                                <br>
                                                <tr align="center">
                                                    <td width="50%" style="vertical-align: middle;" align="center"><b>รายการ</b></td>
                                                    <td width="50%" style="vertical-align: middle;" align="center"><b>ยอดเงิน</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 30px;"></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px"><b>รถแท็กซี่</b> <?php echo $row['carNum'] ?></td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['carRent'] ?> -.</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px">จำนวนวัน</td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['numDay'] ?> วัน</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px">รามค่าเช่า</td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['hirTotal'] ?> -.</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px"><u>หัก</u> ค่ามัดจำ 50%</td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['hirDeposit'] ?> -.</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-top: 30px;"></td>
                                                    <td style="padding-top: 30px;"></td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px">ค้างชำระ</td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['hirDeposit'] ?> -.</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px">คืนช้าปรับวันละ 1000 <u>คืนช้า</u> <?php echo $row['dateRate'] ?> วัน</td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['Fines'] ?> -.</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px">
                                                        <?php
                                                        if ($row['text_rePair'] == "**หากมีการซ่อมให้ระบุงานซ่อม**") {
                                                            echo "ไม่มีการซ่อมรถ";
                                                        } else {
                                                            echo $row['text_rePair'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['price_rePair'] ?> -.</td>
                                                </tr>
                                                <tr>
                                                    <td width="50%" style="vertical-align: middle; padding-left : 80px">ยอดชำระสุทธิ</td>
                                                    <td width="50%" style="vertical-align: middle; padding-right : 170px" align="right"><?php echo $row['total2'] ?> -.</td>

                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td width="50%" style="vertical-align: middle;" align="center"> <?php echo convertAmountToLetter($row['total2']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center"><br><b>ขอบคุณที่ใช้บริการ...</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </div>
                </div>
                <br>
            </div>
            <div class="container">
                <div class="container">
                    <div>
                        <input name="b_print" type="button" onClick="printdiv('div_print');" value=" Download " class="btn btn--m btn--orange btn--raised" lx-ripple style="background: #3366FF;color: #f9f9f9">
                    </div>
                    <br><br>
                </div>
            </div>
    <?php
        }
    endif
    ?>
    <script>
        function printdiv(printpage) {
            var headstr = "<html><head><title></title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            w = window.open("", "_blank", "k");
            w.document.write(headstr + newstr + footstr);
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
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