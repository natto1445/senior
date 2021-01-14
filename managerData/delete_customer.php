<?php session_start(); ?>

<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../condb/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

//สร้างตัวแปรสำหรับรับค่า member_id จากไฟล์แสดงข้อมูล
$cusCard = $_REQUEST["id"];

$sql = "SELECT * FROM tbcontract WHERE cusCard='$cusCard'";
$query = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($query);

if ($num_rows > 0) {
    $_SESSION["status"] = "ไม่สามารถลบข้อมูลผู้เช่านี้ได้";
    $_SESSION["status_code"] = "error";
    header("location: ../managerData/index_customer.php");
    exit();
} else {
    //ลบข้อมูลออกจาก database ตาม member_id ที่ส่งมา

    $sql = "DELETE FROM tbcustomer WHERE cusCard ='$cusCard' ";
    $result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error($con));

    //จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม

    if ($result) {
        $_SESSION['status'] = "ลบข้อมูลสำเร็จ !";
        $_SESSION['status_code'] = "success";
        header('Location: ../managerData/index_customer.php');
    } else {
        $_SESSION['status'] = "ลบข้อมูลไม่สำเร็จ !";
        $_SESSION['status_code'] = "error";
        header('Location: ../managerData/index_customer.php');
    }
}

?>