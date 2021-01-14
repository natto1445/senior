<?php session_start(); ?>

<mate charset="utf-8" />
<?php include('../condb/condb.php');

$rand = mt_rand(100000, 999999);
$name_file =  $rand . $_FILES['upload']['name'];
$tmp_name =  $_FILES['upload']['tmp_name'];
$locate_img = "../images/customer/";
//echo $name_file;

//สร้างตัวแปร
$cusCard = $_POST['cusCard'];
$cusName = $_POST['cusName'];
$cusDriver = $_POST['cusDriver'];
$cusAdd = $_POST['cusAdd'];
$cusTel = $_POST['cusTel'];
$cusStatus = $_POST['cusStatus'];

$sql = "SELECT cusCard FROM tbcustomer WHERE cusCard='$cusCard'";
$result = mysqli_query($con, $sql);
$row = mysqli_num_rows($result);

if ($row > 0) {
    $_SESSION['status'] = "มีหมายเลขบัตรประจำตัวนี้แล้ว !";
    $_SESSION['status_code'] = "error";
    header('Location: ../managerData/create_customer.php');
    die();
}

$sql = "SELECT cusDriver FROM tbcustomer WHERE cusDriver='$cusDriver'";
$result = mysqli_query($con, $sql);
$row = mysqli_num_rows($result);

if ($row > 0) {
    $_SESSION['status'] = "มีหมายเลขใบขับขี่นี้แล้ว !";
    $_SESSION['status_code'] = "error";
    header('Location: ../managerData/create_customer.php');
    die();
}

//เพิ่มข้อมูล
move_uploaded_file($tmp_name, $locate_img . $name_file);
if ($cusCard == "" || $cusName == "" || $cusDriver == "" || $cusAdd == "" || $cusTel == "" || $cusStatus == "" || $_FILES['upload']['name'] == "") {
    $_SESSION['status'] = "กรุณากรอกข้อมูล !";
    $_SESSION['status_code'] = "info";
    header('Location: ../managerData/create_customer.php');
} else {
    $sql = " INSERT INTO tbcustomer
        (cusCard, cusName, cusDriver, cusAdd, cusTel, cusStatus, cusPic)
        VALUES
        ('$cusCard', '$cusName', '$cusDriver', '$cusAdd', '$cusTel', '$cusStatus', '$name_file')";
    $result = mysqli_query($con, $sql) or die("Error in query: $sql " . mysqli_error($con));
    mysqli_close($con);

    //ถ้าสำเร็จให้ขึ้นอะไร
    if ($result) {
        $_SESSION['status'] = "เพิ่มข้อมูลสำเร็จ !";
        $_SESSION['status_code'] = "success";
        header('Location: ../managerData/index_customer.php');
    } else {
        //กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
        $_SESSION['status'] = "เกิดข้อผิดพลาดในระบบ !";
        $_SESSION['status_code'] = "error";
        header('Location: ../managerData/create_customer.php');
    }
}

?>