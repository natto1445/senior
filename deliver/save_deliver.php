<?php
session_start();
include("../condb/condb.php");

$sql = "SELECT MAX(id) as maxid from tbdelivers ";
$deliver = mysqli_query($con, $sql);
$data = mysqli_fetch_array($deliver);
$data2 = $data['maxid'] + 1;

//print_r($_POST);
$carID = $_POST["carID"];
$hirNum = $_POST["hirNum"];

$query_hir = "SELECT hirPattern FROM tbcontract WHERE hirNum='$hirNum'";
$check_hir = mysqli_query($con, $query_hir);
$row_hir = mysqli_fetch_assoc($check_hir);

//echo $row_hir['hirPattern'];

$sql3 = "SELECT * FROM tbtaxi WHERE carID='$carID'";
$taxi = mysqli_query($con, $sql3);
$data3 = mysqli_fetch_array($taxi);

$date = date('Y');
$delID = "DL-$date-00$data2";

if ($data3['carStatus'] == "มีการซ่อมรถ") {
    $_SESSION["save_contract_msg"] = "รถแท็กซี่คันนี้เกิดความเสียหาย กรุณาทำการซ่อมรถก่อน";
    $_SESSION["save_contract_msg1"] = "error";
    header("location:create_deliver.php");
    exit();
}
$query_check = "SELECT check_status FROM `tbtaxi` WHERE carID='$carID'";
$check = mysqli_query($con, $query_check);
$row = mysqli_fetch_assoc($check);

//echo $row['check_status'];
//echo $row_hir['hirPattern'];

if ($row['check_status'] == "1" && $row_hir['hirPattern'] == "แบบเต็มวัน") {
    $_SESSION["save_contract_msg"] = "รถยังไม่รับคืน ไม่สามารถปล่อยรถได้ ติดต่อแอดมินเพื่อขอเปลี่ยนรถก่อน";
    $_SESSION["save_contract_msg1"] = "error";
    header("location:create_deliver.php");
    exit();
}

$delDate = $_POST["delDate"];
$hirNum = $_POST["hirNum"];
$usrID = $_POST["usrID"];

$sql = "INSERT INTO tbdelivers (delID,delDate,hirNum,usrID) VALUES
    ('$delID','$delDate','$hirNum','$usrID')";
$query = mysqli_query($con, $sql);

$sql2 = "UPDATE tbcontract SET deliver='1' WHERE hirNum='$hirNum'";
$query2 = mysqli_query($con, $sql2);

$sql3 = "UPDATE tbtaxi SET check_status='1' WHERE carID='$carID'";
$query3 = mysqli_query($con, $sql3);

if ($query && $query2 && $query3) {
    $_SESSION["save_contract_msg"] = "ปล่อยรถแท็กซี่สำเร็จ";
    $_SESSION["save_contract_msg1"] = "success";
    header("location:create_deliver.php");
} else {
    $_SESSION["save_contract_msg"] = "ปล่อยรถแท็กซี่ไม่สำเร็จ";
    $_SESSION["save_contract_msg1"] = "error";
    header("location:create_deliver.php");
}
