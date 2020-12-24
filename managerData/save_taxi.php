<?php session_start();?>

<mate charset ="utf-8" />
<?php include ('../condb/condb.php');

    $rand = mt_rand(100000, 999999);
    $name_file =  $rand.$_FILES['upload']['name'];
    $tmp_name =  $_FILES['upload']['tmp_name'];
    $locate_img ="../images/taxi/";
    //echo $name_file;

    //สร้างตัวแปร
    $carID = $_POST['carID'];
    $carBrand = $_POST['carBrand'];
    $carGen = $_POST['carGen'];
    $carNum = $_POST['carNum'];
    $carBody = $_POST['carBody'];
    $carYN = $_POST['carYN'];
    $carRent = $_POST['carRent'];
    $carColor = $_POST['carColor'];
    $carStatus = $_POST['carStatus'];

    $sql = "SELECT carNum FROM tbtaxi WHERE carNum='$carNum'";
    $result = mysqli_query($con,$sql);
    //  print_r($result);
     $row = mysqli_num_rows($result);
    // die(); 
         if ($row>0){
            $_SESSION['status'] = "มีหมายเลขทะเบียนรถแท็กซี่นี้แล้ว !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_taxi.php');
            die();
        }

    //เพิ่มข้อมูล
    move_uploaded_file($tmp_name,$locate_img.$name_file);
    if($carBrand=="" || $carGen=="" || $carNum=="" || $carBody=="" || $carYN=="" || $carRent=="" || $carColor=="" || $carStatus=="" || $name_file==""){
            $_SESSION['status'] = "กรุณากรอกข้อมูล !";
            $_SESSION['status_code'] = "info";
            header('Location: ../managerData/create_taxi.php');
    }else{
        $sql = " INSERT INTO tbtaxi
        (carID, carBrand, carGen, carNum, carBody, carYN, carRent, carColor, carStatus, carPic)
        VALUES
        ('$carID', '$carBrand', '$carGen', '$carNum', '$carBody', '$carYN', '$carRent', '$carColor', '$carStatus', '$name_file')";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_close($con);

        //ถ้าสำเร็จให้ขึ้นอะไร
        if ($result){
            $_SESSION['status'] = "เพิ่มข้อมูลสำเร็จ !";
            $_SESSION['status_code'] = "success";
            header('Location: ../managerData/index_taxi.php');
            }
        else {
        //กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
            $_SESSION['status'] = "เกิดข้อผิดพลาดในระบบ !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_taxi.php');
        }
    }

?>