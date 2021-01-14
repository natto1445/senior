<?php
session_start();
include("../condb/condb.php");

//print_r($_POST);

$payID = $_POST["payID"]; //เลขที่ชำระ...
$hirNum = $_POST["hirNum"]; //เลขที่สัญญา...
$cusCard = $_POST["cusCard"]; //รหัสลูกค้า...
$usrID = $_SESSION["usrID"]; //รหัสพนักงาน...
$hirStart = $_POST["hirStart"]; //วันที่เรื่มเช่า...
$hirEnd = $_POST["hirEnd"]; //วันที่สิ้นสุด...
$numDay = $_POST["numDay"]; //จำนวนวัน...
$carID = $_POST["carID"]; //รหัสรถ...
$totalhir = $_POST["totalhir"]; //ค่าเช่าทั้งหมด...
$hirDeposit = $_POST["hirDeposit"]; //มัดจำ...
$balance_hirDeposit = $_POST["balance_hirDeposit"]; //ค่าเช่าหลังหักมัดจำ...
$Fines = $_POST["Fines"]; //ค่าปรับคืนช้า...
$text_rePair = $_POST["text_rePair"]; //การซ่อมรถ...
$repair = $_POST["repair"]; //การซ่อมรถ...
$price_rePair = $_POST["price_rePair"]; //ราคาซ่อม...
$balance = $_POST["balance"]; //เงินสุทธืไม่รวมค่าซ่อม...
$total2 = $_POST["total2"]; //เงินสุทธืรวมค่าซ่อม...

$sql_data = "SELECT hirNum FROM tbpayment WHERE hirNum='$hirNum'";
$query_data = mysqli_query($con, $sql_data);
$row = mysqli_num_rows($query_data);
//echo ($row);
if ($row > 0) {
    $_SESSION['status'] = "สัญญาเช่านี้ได้ถูกชำระเงินแล้ว !";
    $_SESSION['status_code'] = "error";
    header('Location: create_payment.php');
    die();
}

//echo ($text_rePair);

$sql = "INSERT INTO tbpayment (payID,hirNum,cusCard,usrID,hirStart,
    hirEnd,numDay,carID,totalhir,hirDeposit,balance_hirDeposit,Fines,text_rePair,repair,price_rePair,balance,total2) VALUES
    ('$payID','$hirNum','$cusCard','$usrID','$hirStart','$hirEnd',
    '$numDay','$carID','$totalhir','$hirDeposit','$balance_hirDeposit','$Fines','$text_rePair','$repair','$price_rePair','$balance','$total2')";
$query = mysqli_query($con, $sql);

$sql2 = "UPDATE tbcontract SET deliver='ชำระแล้ว' WHERE hirNum='$hirNum'";
$query2 = mysqli_query($con, $sql2);

if ($repair == "มีการซ่อมรถ") {
    $sql3 = "UPDATE tbtaxi SET carStatus='มีการซ่อมรถ' WHERE carID='$carID'";
    $query3 = mysqli_query($con, $sql3);
}

if ($text_rePair != "**หากมีการซ่อมให้ระบุงานซ่อม พร้อมราคา 50%**") {
    $sql4 = "UPDATE tbtaxi SET payID='$payID' WHERE carID='$carID'";
    $query4 = mysqli_query($con, $sql4);
}

if ($query && $query2 || $query3 || $query4) {
    $_SESSION["status"] = "บันทึกการชำระสำเร็จ";
    $_SESSION["status_code"] = "success";
    $_SESSION["payID"] = $payID;
    header("location:preview_payment.php");
} else {
    $_SESSION["status"] = "บันทึกการชำระไม่สำเร็จ !";
    $_SESSION["status_code"] = "error";
    header("location:create_payment.php");
}
