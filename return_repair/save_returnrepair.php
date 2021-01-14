<?php
    session_start();
    include("../condb/condb.php");

    //print_r($_POST);

    $retID = $_POST["retID"];
    $repID = $_POST["repID"];
    $datenow = $_POST["datenow"];
    $carID = $_POST['carID'];
    $repair_status = "เสร็จสิ้น";


    $sql = "INSERT INTO tbreturn_repair (returnID,repID,date_return) VALUES
    ('$retID','$repID','$datenow')";
    $query = mysqli_query($con,$sql);


    $sql2 = "UPDATE tbrepair SET repair_status='$repair_status' WHERE repID='$repID'";
    $query2 = mysqli_query($con,$sql2);

    $sql3 = "UPDATE tbtaxi SET carStatus='ว่าง' WHERE carID='$carID'";
    $query3 = mysqli_query($con,$sql3);

    if($query && $query2 && $query3){
        $_SESSION["status"]="รับรถคืนจากซ่อมสำเร็จ";
        $_SESSION["status_code"]="success";
        header("location:index_returnrepair.php");
    }else{
        $_SESSION["status"]="รรับรถคืนจากซ่อมไม่สำเร็จ";
        $_SESSION["status_code"]="error";
        header("location:index_returnrepair.php");
    }
