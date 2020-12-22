<?php session_start();?>

<mate charset ="utf-8" />
<?php include ('../condb/condb.php');	
    //สร้างตัวแปร
    $eBrands = $_POST['eBrand'];
    $tBrands = $_POST['tBrand'];
    
    $sql = "SELECT eBrands FROM tbbrands WHERE eBrands='$eBrands'";
    $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result)==1){
            $_SESSION['status'] = "มียี่ห้อรถนี้ในระบบแล้ว !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_brand.php');
        }

    //เพิ่มข้อมูล
    if($eBrands=="" || $tBrands==""){
            $_SESSION['status'] = "กรุณากรอกข้อมูล !";
            $_SESSION['status_code'] = "info";
            header('Location: ../managerData/create_brand.php');
    }else{
        $sql = " INSERT INTO tbbrands
        (eBrands, tBrands)
        VALUES
        ('$eBrands', '$tBrands')";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_close($con);

        //ถ้าสำเร็จให้ขึ้นอะไร
        if ($result){
            $_SESSION['status'] = "เพิ่มข้อมูลสำเร็จ !";
            $_SESSION['status_code'] = "success";
            header('Location: ../managerData/index_brand.php');
            }
        else {
        //กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
            $_SESSION['status'] = "เกิดข้อผิดพลาดในระบบ !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_brand.php');
        }
    }
?>