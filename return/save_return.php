<?php
session_start();
include("../condb/condb.php");

print_r($_POST);

$carID = $_POST["carID"];
$retID = $_POST["retID"]; //เลขที่รับคืน...
$hirNum = $_POST["hirNum"]; //เลขที่สัญญา...
$hirEnd = $_POST["hirEnd"]; //วันที่ต้องคืน...
$datenow = $_POST["datenow"]; //วันที่เอามาคืน...
$time = $_POST["time"]; //เวลาเอามาคืน...
$usrID = $_POST["usrID"]; //พนักงานรับคืน...
$cusCard = $_POST["cusCard"]; //ลูกค้า...
$numRate = $_POST["numRate"]; //จำนวนวันคืนช้า...
$timeRate = $_SESSION["timeRate"]; //เวลาคืนช้า...
$Fines = $_POST["Fines"]; //ค่าปรับ...
$hirTotal = $_POST["hirTotal"]; //ยอดเช่าทั้งหมด...
$hirDeposit = $_POST["hirDeposit"]; //เงินมัดจำ...
$balance = $_POST["balance"]; //เงินที่ต้องจ่ายหลังหักมัดจำ...
$total = $_POST["total"]; //เงินที่ต้องจ่ายหลังหักมัดจำ+ค่าปรับ...


$sql = "INSERT INTO tbreturn (retID,recDate,hirNum,retDate,retTime,usrID,
    dateRate,timeRate,hirTotal,hirDeposit,balance,Fines,total) VALUES
    ('$retID','$hirEnd','$hirNum','$datenow','$time','$usrID','$numRate',
    '$timeRate','$hirTotal','$hirDeposit','$balance','$Fines','$total')";
$query = mysqli_query($con, $sql);

$sql2 = "UPDATE tbcustomer SET cusStatus='ยังไม่เช่า' WHERE cusCard='$cusCard'";
$query2 = mysqli_query($con, $sql2);

$sql3 = "UPDATE tbcontract SET deliver='รอชำระเงิน',hirStatus='เสร็จสิ้น' WHERE hirNum='$hirNum'";
$query3 = mysqli_query($con, $sql3);

$sql4 = "UPDATE tbtaxi SET check_status='0' WHERE carID='$carID'";
$query4 = mysqli_query($con, $sql4);

if ($query && $query2 && $query3 && $query4) {
    $_SESSION["status"] = "รับคืนรถสำเร็จ";
    $_SESSION["status_code"] = "success";
    header("location:create_return.php");
} else {
    $_SESSION["status"] = "รับคืนรถไม่สำเร็จ";
    $_SESSION["status_code"] = "error";
    header("location:create_return.php");
}
