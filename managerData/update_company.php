<?php session_start();?>

<mate charset ="utf-8" />
<?php 
    include ('../condb/condb.php');
    
    $rand = mt_rand(100000, 999999);
    $name_file =  $rand.$_FILES['upload']['name'];
    $tmp_name =  $_FILES['upload']['tmp_name'];
    $locate_img ="../images/company/";
    //echo $name_file;

    $comID = $_POST["comID"];
	$comName = $_POST["comName"];
	$comOwner = $_POST["comOwner"];
	$comAdd = $_POST["comAdd"];
	$cusPic = $_POST["upload"];
    
    
	
	if($comID=="" || $comName=="" || $comAdd=="" || $comOwner==""){
		$_SESSION['status'] = "กรุณากรอกข้อมูล !";
        $_SESSION['status_code'] = "info";
        header("Location: ../managerData/edit_company.php?id=$comID");
	}else{
        move_uploaded_file($tmp_name,$locate_img.$name_file);
		$sql = "UPDATE tbcompany SET 
			comID = '".$_POST["comID"]."' ,
			comName = '".$_POST["comName"]."' ,
			comOwner = '".$_POST["comOwner"]."' ,
			comAdd = '".$_POST["comAdd"]."' ,
            comLogo = '$name_file'
            WHERE comID = '".$_POST["comID"]."' ";
            
            if($_FILES['upload']['name'] == null || $name_file == empty($_FILES['upload']['name'])){
                $sql = "UPDATE tbcompany SET 
                comID = '".$_POST["comID"]."' ,
                comName = '".$_POST["comName"]."' ,
				comOwner = '".$_POST["comOwner"]."' ,
                comAdd = '".$_POST["comAdd"]."'
                WHERE comID = '".$_POST["comID"]."' ";
            }
			$result = mysqli_query($con,$sql);

			if($result) {
				$_SESSION['status'] = "อัพเดทข้อมูลสำเร็จ !";
				$_SESSION['status_code'] = "success";
				header('Location: ../managerData/index_company.php');
			}else{
				$_SESSION['status'] = "อัพเดทข้อมูลไม่สำเร็จ !";
				$_SESSION['status_code'] = "error";
				header('Location: ../managerData/index_company.php');
			}
	}

	mysqli_close($con);
?>
