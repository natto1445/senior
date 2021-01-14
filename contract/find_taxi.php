<?php
session_start();
include("../condb/condb.php");

//print_r($_POST);

$hirStart_find = $_POST["hirStart_find"];
$hirEnd_find = $_POST["hirEnd_find"];
$hirPattern_find = $_POST["hirPattern_find"];

$date1=date_create($hirStart_find);
$date2=date_create($hirEnd_find);
$diff=date_diff($date1,$date2);

$_SESSION["hirStart"] = $hirStart_find;
$_SESSION["hirEnd"] = $hirEnd_find;
$_SESSION["pattern"] = $hirPattern_find;
$_SESSION["numDay"] = $diff->format("%a")+1;


if ($hirPattern_find == "แบบเต็มวัน") {
    $sql = "SELECT * FROM tbcontract
    WHERE (hirStart BETWEEN '$hirStart_find' AND '$hirEnd_find' 
    OR '$hirStart_find' BETWEEN hirStart AND hirEnd) AND (hirPattern NOT IN ('แบบกะเช้า') OR hirPattern NOT IN ('แบบกะดึก') OR hirPattern IN ('$hirPattern_find')) AND hirStatus IN ('จองรถ')";
    $query = mysqli_query($con, $sql);
    $num_rows = mysqli_num_rows($query);

    if ($num_rows > 0) {
        $cars = mysqli_fetch_assoc($query);
        $carID = $cars["carID"];

        $sql2 = "SELECT * FROM tbtaxi WHERE carID NOT IN('$carID')";
        $query2 = mysqli_query($con, $sql2);

        $num_rows2 = mysqli_num_rows($query2);
        if ($num_rows2 <= 0) {
            $_SESSION["no_data"] = "ไม่มีรถแท็กซี่ว่าง";
            header("location:create_contract.php");
            exit();
        } else {
            $_SESSION["carID"] = $carID;
            $_SESSION["data_found"] = "พบข้อมูล";
            header("location:create_contract.php");
            exit();
        }
    } else {
        $_SESSION["carID"] = $carID;
        $_SESSION["data_found"] = "พบข้อมูล";
        header("location:create_contract.php");
        exit();
    }
} else {

    $sql = "SELECT * FROM tbcontract
    WHERE (hirStart BETWEEN '$hirStart_find' AND '$hirEnd_find' 
    OR '$hirStart_find' BETWEEN hirStart AND hirEnd) AND (hirPattern IN ('$hirPattern_find') OR hirPattern IN ('แบบเต็มวัน')) AND hirStatus IN ('จองรถ')";
    $query = mysqli_query($con, $sql);
    $num_rows = mysqli_num_rows($query);

    if ($num_rows > 0) {
        $cars = mysqli_fetch_assoc($query);
        $carID = $cars["carID"];

        $sql2 = "SELECT * FROM tbtaxi WHERE carID NOT IN('$carID')";
        $query2 = mysqli_query($con, $sql2);

        $num_rows2 = mysqli_num_rows($query2);
        if ($num_rows2 <= 0) {
            $_SESSION["no_data"] = "ไม่มีรถแท็กซี่ว่าง";
            header("location:create_contract.php");
            exit();
        } else {
            $_SESSION["carID"] = $carID;
            $_SESSION["data_found"] = "พบข้อมูล";
            header("location:create_contract.php");
            exit();
        }
    } else {
        $_SESSION["carID"] = $carID;
        $_SESSION["data_found"] = "พบข้อมูล";
        header("location:create_contract.php");
        exit();
    }
}

?>