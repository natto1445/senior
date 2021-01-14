<?php
include('../condb/condb.php');
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
<?php
$hirNum = $_REQUEST["id"];

$query = "SELECT * FROM tbcontract  JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID WHERE hirNum='$hirNum'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);

$sql = "SELECT * FROM tbcompany";
$result2 = mysqli_query($con, $sql);
$row2 = mysqli_fetch_array($result2);

?>

<head>
    <title>contract preview</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <br>
        <div class="card">
            <?php
            ob_start();
            ?>
            <div class="card-body" style="width: 100%;">
                <div align="center" style="font-size: 28pt;">สัญญาเช่ารถยนต์</div>
                <div align="right" style="font-size: 18pt;">สัญญาเลขที่&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $row['hirNum']; ?></u></div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญาฉบับนี้ทำขึ้น ณ&nbsp;&nbsp;&nbsp;&nbsp;<U><?php echo $row2['comName']; ?></U>&nbsp;&nbsp;&nbsp;&nbsp;จังหวัด&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $row2['comAdd']; ?></u></div>
                <div style="font-size: 18pt;">เมื่อวันที่&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $row['hirDate']; ?></u>&nbsp;&nbsp;&nbsp;&nbsp;ระหว่าง&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $row['usrName']; ?></u>&nbsp;&nbsp;&nbsp;&nbsp;อยู่ที่&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;ซึ่งต่อไปในสัญญาจะเรียกว่า&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div style="font-size: 18pt;">“ผู้ให้เช่า” ฝ่ายหนึ่งกับ&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $row['cusName']; ?></u>&nbsp;&nbsp;&nbsp;&nbsp;อยู่ที่&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo $row['cusAdd']; ?></u>&nbsp;&nbsp;&nbsp;&nbsp;ซึ่งต่อไปในสัญญาจะเรียกว่า “ผู้เช่า”&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div style="font-size: 18pt;" align="right">คู่สัญญาทั้งสองฝ่ายตกลงทำสัญญาฉบับนี้ โดยมีเงื่อนไขและรายละเอียดดังต่อไปนี้</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 1 ผู้ให้เช่าและผู้เช่าตกลงเช่ารถยนต์ยี่ห้อ&nbsp;&nbsp;<u><?php echo $row['carBrand']; ?></u>&nbsp;&nbsp;ทะเบียน&nbsp;&nbsp;<u><?php echo $row['carNum']; ?></u>&nbsp;&nbsp;</div>
                <div style="font-size: 18pt;">โดยมีกำหนดระยะเวลาเช่า&nbsp;&nbsp;<u><?php echo $row['numDay']; ?></u>&nbsp;&nbsp;วัน นับตั้งแต่วันที่&nbsp;&nbsp;<u><?php echo $row['hirStart']; ?></u>&nbsp;&nbsp;ถึงวันที่&nbsp;&nbsp;<u><?php echo $row['hirEnd']; ?></u>&nbsp;&nbsp;</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 2 ผู้เช่าตกลงชำระค่าเช่าให้แก่ผู้ให้เช่า การชำระค่าเช่านั้น ผู้เช่าจะชำระค่าเช่า โดยจ่ายเป็นเงินสด โดยวางมัดจำแล้ว 50% เป็นเงิน&nbsp;&nbsp;<u><?php echo $row['hirDeposit']; ?></u>&nbsp;&nbsp;บาท&nbsp;&nbsp;ซึ่งค่าเช่าทั้งหมดคือ&nbsp;&nbsp;<u><?php echo $row['numDay'] * $row['carRent']; ?></u>&nbsp;&nbsp;</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 3 ผู้เช่าได้ตรวจสภาพรถยนต์ที่เช่าเรียบร้อยแล้ว และเห็นว่ามีสภาพ และการใช้งานปกติตามที่ตกลงกันแล้ว จึงได้ทำการรับมอบจากผู้ให้เช่าไปแล้วในวันนี้</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 4 ผู้เช่าจะรับผิดชอบต่อความเสียหายใด ๆ ที่เกิดขึ้นแก่รถยนต์ของผู้ให้เช่า และต่อบุคคลภายนอก ในกรณีที่เกิดอุบัติเหตุไม่ว่าจะเป็นความผิดของผู้เช่าหรือไม่ก็ตาม</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 5 ผู้เช่าจะรับผิดชอบต่อความเสียหายใด ๆ ที่เกิดขึ้นแก่ชีวิต หรือความบาดเจ็บ ของบุคคลภายนอก หรือแก่ตัวผู้เช่าเองก็ตาม</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 6 ผู้เช่าจะรับผิดชอบต่อความเสียหายใด ๆ ที่เกิดขึ้นแก่กรณีที่รถยนต์สูญหาย หรือถูกขโมย และ/หรือ ล้อรถ เครื่องมือ เครื่องอุปกรณ์ของผู้ให้เช่าหาย หรือถูกขโมย รับผิดชอบ 50% กรณีเสียหาย</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 7 ผู้เช่าจะคืนรถยนต์ พร้อมด้วยอุปกรณ์ที่เช่าไปคืนแก่ผู้ให้เช่า ณ สถานที่ที่ให้เช่า ในสภาพเรียบร้อยใช้งานได้ตามปกติ</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อ 8 ผู้เช่ายอมให้สัญญาว่าจะไม่นำรถที่เช่าไปให้คนอื่นเช่าช่วง หรือให้ผู้อื่นยืม หรือนำไปด้วยประการใดๆ เป็นอันขาด เว้นแต่จะได้รับอนุญาตจากผู้ให้เช่าเป็นลายลักษณ์อักษร</div>
                <div style="font-size: 18pt;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญานี้ทำขึ้นเป็นสองฉบับ มีข้อความถูกต้องตรงกัน และคู่สัญญาได้อ่านโดยตลอดแล้ว เห็นว่าถูกต้องตามเจตนารมณ์แห่งตนทุกประการ จึงได้ลงลายมือชื่อและประทับตราสำคัญต่อหน้าพยานเป็นสำคัญ</div><br><br><br>
                <div style="font-size: 18pt; padding-right: 20px;" align="right">ลงชื่อ………………………………………ผู้เช่า</div>
                <div style="font-size: 18pt; padding-right: 70px;" align="right">(&nbsp;&nbsp;&nbsp;<?php echo $row['cusName']; ?>&nbsp;&nbsp;&nbsp;)</div>
                <div style="font-size: 18pt; padding-right: 20px;" align="right">ลงชื่อ……………………………………ผู้ให้เช่า</div>
                <div style="font-size: 18pt; padding-right: 70px;" align="right">(&nbsp;&nbsp;&nbsp;<?php echo $row['usrName']; ?>&nbsp;&nbsp;&nbsp;)</div>
                <div style="font-size: 18pt; padding-right: 20px;" align="right">ลงชื่อ………………………………………พยาน</div>
                <div style="font-size: 18pt; padding-right: 70px;" align="right">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</div>
            </div>
            <?php
            $html = ob_get_contents();
            $mpdf->WriteHTML($html);
            $mpdf->Output("ContractReport.pdf");
            ob_end_flush();
            ?>
        </div>
        <br>
        <a class="btn btn-success" href="ContractReport.pdf"><i class="fa fa-print" aria-hidden="true">Download</i></a>
        <br>
        <br>
        <br>
        <?php
        mysqli_close($con);
        ?>
    </div>
</body>

</html>
<?php
include('../includes/scripts.php');
?>