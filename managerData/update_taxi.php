<?php session_start();?>

<mate charset ="utf-8" />
<?php 
    include ('../condb/condb.php');
    
    $rand = mt_rand(100000, 999999);
    $name_file =  $rand.$_FILES['upload']['name'];
    $tmp_name =  $_FILES['upload']['tmp_name'];
    $locate_img ="../images/taxi/";
    //echo $name_file;

    $carID = $_POST["carID"];
	$carBrand = $_POST["carBrand"];
	$carGen = $_POST["carGen"];
	$carNum = $_POST["carNum"];
    $carBody = $_POST["carBody"];
    $carYN = $_POST["carYN"];
	$carRent = $_POST["carRent"];
    $carColor = $_POST["carColor"];
    $upload = $_POST["upload"];
    
    
	
	if($carBrand=="" || $carGen=="" || $carNum=="" || $carBody=="" || $carYN=="" || $carRent=="" || $carColor==""){
		$_SESSION['status'] = "กรุณากรอกข้อมูล !";
        $_SESSION['status_code'] = "info";
        header("Location: ../managerData/edit_taxi.php?id=$carID ");
	}else{
        move_uploaded_file($tmp_name,$locate_img.$name_file);
		$sql = "UPDATE tbtaxi SET 
			carBrand = '".$_POST["carBrand"]."' ,
			carGen = '".$_POST["carGen"]."' ,
			carNum = '".$_POST["carNum"]."' ,
			carBody = '".$_POST["carBody"]."' ,
			carYN = '".$_POST["carYN"]."',
            carRent = '".$_POST["carRent"]."',
            carColor = '".$_POST["carColor"]."',
            carPic = '$name_file'
            WHERE carID = '".$_POST["carID"]."' ";
            
            if($_FILES['upload']['name'] == null || $name_file == empty($_FILES['upload']['name'])){
                $sql = "UPDATE tbtaxi SET 
                carBrand = '".$_POST["carBrand"]."' ,
                carGen = '".$_POST["carGen"]."' ,
                carNum = '".$_POST["carNum"]."' ,
                carBody = '".$_POST["carBody"]."' ,
                carYN = '".$_POST["carYN"]."',
                carRent = '".$_POST["carRent"]."',
                carColor = '".$_POST["carColor"]."'
                WHERE carID = '".$_POST["carID"]."' ";
            }
			$result = mysqli_query($con,$sql);

			if($result) {
				$_SESSION['status'] = "อัพเดทข้อมูลสำเร็จ !";
				$_SESSION['status_code'] = "success";
				header('Location: ../managerData/index_taxi.php');
			}else{
				$_SESSION['status'] = "อัพเดทข้อมูลไม่สำเร็จ !";
				$_SESSION['status_code'] = "error";
				header('Location: ../managerData/index_taxi.php');
			}
	}

	mysqli_close($con);
?>
