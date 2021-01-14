<?php
session_start();
include("../condb/condb.php");

$sql = "SELECT MAX(id) as maxid from tbdelivers ";
$deliver = mysqli_query($con, $sql);
$data = mysqli_fetch_array($deliver);
$data2 = $data['maxid']+1;

$date = date('Y');

$delID = "DL-$date-00$data2";

//echo $delID;
//print_r($_POST);

    $delDate = $_POST["delDate"];
    $hirNum = $_POST["hirNum"];
    $usrID = $_POST["usrID"];
    
    $sql = "INSERT INTO tbdelivers (delID,delDate,hirNum,usrID) VALUES
    ('$delID','$delDate','$hirNum','$usrID')";
    $query = mysqli_query($con,$sql);

    /* อัพเดตสถานะสัญญา */
    $sql2 = "UPDATE tbcontract SET deliver='1' WHERE hirNum='$hirNum'";
    $query2 = mysqli_query($con,$sql2);

    if($query && $query2){
        $_SESSION["save_contract_msg"]="ปล่อยรถแท็กซี่สำเร็จ";
        $_SESSION["save_contract_msg1"]="success";
        header("location:create_deliver.php");
    }else{
        $_SESSION["save_contract_msg"]="ปล่อยรถแท็กซี่ไม่สำเร็จ";
        $_SESSION["save_contract_msg1"]="error";
        header("location:create_deliver.php");
    }
