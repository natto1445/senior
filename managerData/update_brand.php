<?php session_start();?>

<mate charset ="utf-8" />
<?php 
    include ('../condb/condb.php');

    $eBrands = $_POST["eBrands"];
    $tBrands = $_POST["tBrands"];

    if($_POST["tBrands"]!=""){
        $sql = "UPDATE tbbrands SET 
			tBrands = '$tBrands'
            WHERE eBrands = '".$_POST["eBrands"]."' ";
            $result = mysqli_query($con,$sql);

            if($result) {
                $_SESSION['status'] = "อัพเดทข้อมูลสำเร็จ !";
                $_SESSION['status_code'] = "success";
                header('Location: ../managerData/index_brand.php');
            }else{
                $_SESSION['status'] = "อัพเดทข้อมูลไม่สำเร็จ !";
                $_SESSION['status_code'] = "error";
                header('Location: ../managerData/index_brand.php');
            }
    }else{
        $_SESSION['status'] = "กรุณากรอกข้อมูล !";
        $_SESSION['status_code'] = "info";
        header("Location: ../managerData/edit_brand.php?id=$eBrands ");
    }

	mysqli_close($con);
?>
