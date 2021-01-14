<?php
    session_start();
    include("../condb/condb.php");

    //print_r($_POST);

    $repID = $_POST["repID"];
    $usrID = $_POST["usrID"];
    $hirNum = $_POST["hirNum"];
    $payID = $_POST["payID"];
    $cusCard = $_POST["cusCard"];
    $carID = $_POST["carID"];
    $text_rePair = $_POST["text_rePair"];
    $price_rePair = $_POST["price_rePair"];
    $dateRepair = $_POST["dateRepair"];
    $dateSuc = $_POST["dateSuc"];
    $repair_status = "กำลังซ่อม";


    $sql = "INSERT INTO tbrepair (repID,usrID,hirNum,payID,cusCard,carID,
    text_rePair,price_rePair,dateRepair,dateSuc,repair_status) VALUES
    ('$repID','$usrID','$hirNum','$payID','$cusCard','$carID','$text_rePair',
    '$price_rePair','$dateRepair','$dateSuc','$repair_status')";
    $query = mysqli_query($con,$sql);


    $sql2 = "UPDATE tbtaxi SET carStatus='กำลังซ่อม',payID='' WHERE carID='$carID'";
    $query2 = mysqli_query($con,$sql2);

    if($query && $query2){
        $_SESSION["status"]="ส่งซ่อมรถสำเร็จ";
        $_SESSION["status_code"]="success";
        header("location:create_repair.php");
    }else{
        $_SESSION["status"]="ส่งซ่อมรถไม่สำเร็จ";
        $_SESSION["status_code"]="error";
        header("location:create_repair.php.php");
    }
