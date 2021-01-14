<?php
session_start();
include("../condb/condb.php");

$del_date = $_POST["del_date"];
//echo $del_date

$sql = "SELECT * FROM tbcontract JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID  WHERE hirStart = '$del_date' AND hirStatus='จองรถ' AND tbcontract.deliver='0'";
$query = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($query);
$find = mysqli_fetch_assoc($query);
$data = $find["hirStart"];

if ($num_rows <= 0) {
    $_SESSION["status"] = "ไม่มีสัญญาที่ถูกปล่อยเช่าในวันนี้";
    $_SESSION["status_code"] = "error";
    header("location:create_deliver.php");
    exit();
} else {
    $_SESSION["data"] = $data;
    $_SESSION["data_true"] = "พบข้อมูล";
    $_SESSION["status"] = "พบสัญญาเช่า";
    $_SESSION["status_code"] = "success";
    header("location:create_deliver.php");
    exit();
}
?>