<?php
session_start();
include("../condb/condb.php");

$sql = "SELECT MAX(id) as maxid from tbdelivers ";
$deliver = mysqli_query($con, $sql);
$data = mysqli_fetch_array($deliver);
$data2 = $data['maxid'] + 1;

$carID = $_POST["carID"];

$sql3 = "SELECT * FROM tbtaxi WHERE carID='$carID'";
$taxi = mysqli_query($con, $sql3);
$data3 = mysqli_fetch_array($taxi);

$date = date('Y');
$delID = "DL-$date-00$data2";

if ($data3['carStatus'] == "มีการซ่อมรถ") {
    //echo "test";
    $_SESSION["save_contract_msg"] = "รถแท็กซี่คันนี้เกิดความเสียหาย กรุณาทำการซ่อมรถก่อน";
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

if ($query && $query2) {
    $_SESSION["save_contract_msg"] = "ปล่อยรถแท็กซี่สำเร็จ";
    $_SESSION["save_contract_msg1"] = "success";
    header("location:create_deliver.php");
} else {
    $_SESSION["save_contract_msg"] = "ปล่อยรถแท็กซี่ไม่สำเร็จ";
    $_SESSION["save_contract_msg1"] = "error";
    header("location:create_deliver.php");
}
