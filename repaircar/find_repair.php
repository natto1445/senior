<?php
session_start();
include("../condb/condb.php");

$payID_find = $_POST["payID_find"];
//echo $payID_find

$sql = "SELECT * FROM tbpayment JOIN tbtaxi ON tbpayment.carID=tbtaxi.carID WHERE tbpayment.payID='$payID_find'";
$query = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($query);
$find = mysqli_fetch_assoc($query);
$data = $find["payID"];

//echo ($data);

if ($num_rows <= 0) {
    $_SESSION["status"] = "เกิดข้อผิดพลาด";
    $_SESSION["status_code"] = "error";
    header("location:create_repair.php");
    exit();
} else {
    $_SESSION["data"] = $data;
    $_SESSION["data_true"] = "พบข้อมูล";
    $_SESSION["status"] = "ตรวจสอบข้อมูลก่อนส่งซ่อม";
    $_SESSION["status_code"] = "success";
    header("location:create_repair.php");
    exit();
}
?>