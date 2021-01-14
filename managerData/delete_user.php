<?php session_start(); ?>

<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../condb/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

//สร้างตัวแปรสำหรับรับค่า member_id จากไฟล์แสดงข้อมูล
$usrID = $_REQUEST["id"];
$usrID_log = $_SESSION["usrID"];

$sql = "SELECT * FROM tbcontract WHERE usrID='$usrID'";
$query = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($query);

//echo $num_rows;
if ($num_rows > 0) {
    $_SESSION["status"] = "ไม่สามารถลบข้อมูลผู้ใช้งานนี้ได้";
    $_SESSION["status_code"] = "error";
    header("location: ../managerData/index_user.php");
    exit();
} elseif($usrID==$usrID_log){
    $_SESSION["status"] = "ผู้ใช้งานนี้กำลังใช้งานระบบ";
    $_SESSION["status_code"] = "error";
    header("location: ../managerData/index_user.php");
    exit();
} else {
    //ลบข้อมูลออกจาก database ตาม member_id ที่ส่งมา
    $sql = "DELETE FROM tbuser WHERE usrID='$usrID' ";
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));

    //จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม

    if($result){
            $_SESSION['status'] = "ลบข้อมูลสำเร็จ !";
            $_SESSION['status_code'] = "success";
            header('Location: ../managerData/index_user.php');
        }
        else{
            $_SESSION['status'] = "ลบข้อมูลไม่สำเร็จ !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/index_user.php');
    }
}


?>