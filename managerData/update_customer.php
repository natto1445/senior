<?php session_start();?>

<mate charset ="utf-8" />
<?php 
    include ('../condb/condb.php');
    
    $rand = mt_rand(100000, 999999);
    $name_file =  $rand.$_FILES['upload']['name'];
    $tmp_name =  $_FILES['upload']['tmp_name'];
    $locate_img ="../images/customer/";
    //echo $name_file;

    $cusCard = $_POST["cusCard"];
	$cusName = $_POST["cusName"];
	$cusDriver = $_POST["cusDriver"];
	$cusAdd = $_POST["cusAdd"];
    $cusTel = $_POST["cusTel"];
    $cusStatus = $_POST["cusStatus"];
	$cusPic = $_POST["upload"];
    
    
	
	if($cusCard=="" || $cusName=="" || $cusDriver=="" || $cusAdd=="" || $cusTel=="" || $cusStatus==""){
		$_SESSION['status'] = "กรุณากรอกข้อมูล !";
        $_SESSION['status_code'] = "info";
        header("Location: ../managerData/edit_customer.php?id=$cusCard ");
	}else{
        move_uploaded_file($tmp_name,$locate_img.$name_file);
		$sql = "UPDATE tbcustomer SET 
			cusCard = '".$_POST["cusCard"]."' ,
			cusName = '".$_POST["cusName"]."' ,
			cusDriver = '".$_POST["cusDriver"]."' ,
			cusAdd = '".$_POST["cusAdd"]."' ,
			cusTel = '".$_POST["cusTel"]."',
            cusStatus = '".$_POST["cusStatus"]."',
            cusPic = '$name_file'
            WHERE cusCard = '".$_POST["cusCard"]."' ";
            
            if($_FILES['upload']['name'] == null || $name_file == empty($_FILES['upload']['name'])){
                $sql = "UPDATE tbcustomer SET 
                cusCard = '".$_POST["cusCard"]."' ,
                cusName = '".$_POST["cusName"]."' ,
                cusDriver = '".$_POST["cusDriver"]."' ,
                cusAdd = '".$_POST["cusAdd"]."' ,
                cusTel = '".$_POST["cusTel"]."',
                cusStatus = '".$_POST["cusStatus"]."'
                WHERE cusCard = '".$_POST["cusCard"]."' ";
            }
			$result = mysqli_query($con,$sql);

			if($result) {
				$_SESSION['status'] = "อัพเดทข้อมูลสำเร็จ !";
				$_SESSION['status_code'] = "success";
				header('Location: ../managerData/index_customer.php');
			}else{
				$_SESSION['status'] = "อัพเดทข้อมูลไม่สำเร็จ !";
				$_SESSION['status_code'] = "error";
				header('Location: ../managerData/index_customer.php');
			}
	}

	mysqli_close($con);
?>
