<?php
session_start();
include("../condb/condb.php");

$hirNum_find = $_POST["hirNum_find"];
//echo $hirNum_find

$sql = "SELECT * FROM tbcontract JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID  WHERE hirNum = '$hirNum_find'";
$query = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($query);
$find = mysqli_fetch_assoc($query);
$data = $find["hirNum"];
//echo $data

if ($num_rows <= 0) {
    $_SESSION["status"] = "เกิดข้อผิดพลาด";
    $_SESSION["status_code"] = "error";
    header("location:create_return.php");
    exit();
} else {
    $_SESSION["data"] = $data;
    $_SESSION["data_true"] = "พบข้อมูล";
    $_SESSION["status"] = "ตรวจสอบข้อมูล";
    $_SESSION["status_code"] = "success";
    header("location:create_return.php");
    exit();
}
?>