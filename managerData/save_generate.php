<?php session_start();?>

<mate charset ="utf-8" />
<?php include ('../condb/condb.php');	
    //สร้างตัวแปร
    $eBrands = $_POST['eBrands'];
    $generate = $_POST['generate'];
    
    $sql = "SELECT generate FROM tbgenerate WHERE generate='$generate'";
    $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result)==1){
            $_SESSION['status'] = "มีรุ่นรถนี้ในระบบแล้ว !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_generate.php');
            die();
        }

    //เพิ่มข้อมูล
    if($eBrands=="" || $generate==""){
            $_SESSION['status'] = "กรุณากรอกข้อมูล !";
            $_SESSION['status_code'] = "info";
            header('Location: ../managerData/create_generate.php');
    }else{
        $sql = " INSERT INTO tbgenerate
        (eBrands, generate)
        VALUES
        ('$eBrands', '$generate')";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_close($con);

        //ถ้าสำเร็จให้ขึ้นอะไร
        if ($result){
            $_SESSION['status'] = "เพิ่มข้อมูลสำเร็จ !";
            $_SESSION['status_code'] = "success";
            header('Location: ../managerData/index_generate.php');
            }
        else {
        //กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
            $_SESSION['status'] = "เกิดข้อผิดพลาดในระบบ !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_generate.php');
        }
    }
?>