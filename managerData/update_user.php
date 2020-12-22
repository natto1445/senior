<?php session_start();?>

<mate charset ="utf-8" />
<?php 
	include ('../condb/condb.php');

	$usrID = $_POST["usrID"];
	$usrName = $_POST["usrName"];
	$email = $_POST["email"];
	$numPhone = $_POST["numPhone"];
	
	if($usrName=="" || $email=="" || $numPhone==""){
		$_SESSION['status'] = "กรุณากรอกข้อมูล !";
        $_SESSION['status_code'] = "info";
        header("Location: ../managerData/edit_user.php?id=$usrID ");
	}else{
		$sql = "UPDATE tbuser SET 
			usrName = '".$_POST["usrName"]."' ,
			level = '".$_POST["level"]."' ,
			email = '".$_POST["email"]."' ,
			numPhone = '".$_POST["numPhone"]."' ,
			gender = '".$_POST["gender"]."'
			WHERE usrID = '".$_POST["usrID"]."' ";
			$result = mysqli_query($con,$sql);

			if($result) {
				$_SESSION['status'] = "อัพเดทข้อมูลสำเร็จ !";
				$_SESSION['status_code'] = "success";
				header('Location: ../managerData/index_user.php');
			}else{
				$_SESSION['status'] = "อัพเดทข้อมูลไม่สำเร็จ !";
				$_SESSION['status_code'] = "error";
				header('Location: ../managerData/index_brand.php');
			}
	}

	mysqli_close($con);
?>
