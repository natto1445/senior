<?php
    session_start();
    include("../condb/condb.php");

    //print_r($_POST);

    $hirNum = $_POST["hirNum"];
    $hirDate = $_POST["hirDate"];
    $hirStart = $_POST["hirStart"];
    $hirEnd = $_POST["hirEnd"];
    $hirPattern = $_POST["hirPattern"];
    $timeStart = $_POST["timeStart"];
    $timeEnd = $_POST["timeEnd"];
    $usrID = $_SESSION["usrID"];
    $cusCard = $_POST["cusCard"];
    $numDay = $_POST["numDay"];
    $carRent = $_POST["carRent"];
    $hirDeposit = $_POST["hirDeposit"];
    $hirStatus = $_POST["hirStatus"];
    $hirCarID = $_POST["hirCarID"];
    $deliver = "0";

    /* บันทึกข้อมูลสัญญาเช่า */
    $sql = "INSERT INTO tbcontract (hirNum,cusCard,hirDate,hirStart,hirEnd,hirPattern,
    timeStart,timeEnd,usrID,carID,numDay,hirDeposit,carRent,hirStatus,deliver) VALUES
    ('$hirNum','$cusCard','$hirDate','$hirStart','$hirEnd','$hirPattern','$timeStart',
    '$timeEnd','$usrID','$hirCarID','$numDay','$hirDeposit','$carRent','$hirStatus','$deliver')";
    $query = mysqli_query($con,$sql);

    /* อัพเดตสถานะลูกค้า */
    $sql2 = "UPDATE tbcustomer SET cusStatus='เช่าแล้ว' WHERE cusCard='$cusCard'";
    $query2 = mysqli_query($con,$sql2);

    if($query && $query2){
        $_SESSION["save_contract_msg"]="ทำสัญญาเช่าสำเร็จ";
        $_SESSION["save_contract_msg1"]="success";
        header("location:index_contract.php");
    }else{
        $_SESSION["save_contract_msg"]="ทำสัญญาเช่าไม่สำเร็จ";
        $_SESSION["save_contract_msg1"]="error";
        header("location:index_contract.php");
    }

?>