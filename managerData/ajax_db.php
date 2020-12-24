<?php

    include('../condb/condb.php');


  if (isset($_POST['function']) && $_POST['function'] == 'carBrand') {
  	$id = $_POST['id'];
  	$sql = "SELECT * FROM tbgenerate WHERE eBrands='$id'";
  	$query = mysqli_query($con, $sql);
  	echo '<option value="" selected disabled>-กรุณาเลือกรุ่นรถ-</option>';
  	foreach ($query as $value) {
  		echo '<option value="'.$value['generate'].'">'.$value['generate'].'</option>';
  		
  	}
  }
?>