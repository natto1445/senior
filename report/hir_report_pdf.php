<?php 
include('../includes/helper.php');
include('../vendor/autoload.php');

header("Content-type:application/pdf");
header("Content-disposition: attachment;filename=YOURFILE.pdf");

$mpdf = new \Mpdf\Mpdf();
// ob_start(); // Start get HTML code
$html = '
<!DOCTYPE html>
<html>
	<head>
		<title>รายงาน</title>
		<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
		<style>
		body {
			font-family: sarabun;
		}
		table {
		  	border-collapse: collapse;
		  	width: 100%;
		}
		td, th {
		  	border: 1px solid #dddddd;
		  	text-align: left;
		  	padding: 8px;
		}
		tr:nth-child(even) {
		  	background-color: #dddddd;
		}
		</style>
	</head>
	<body>
		<h1>ตัวอย่างในการเก็บโค้ด HTML มาเป็น PDF</h1>
		<table>
			<tr>
				<th>ชื่อ</th>
				<th>ที่อยู่</th>
				<th>ประเทศ</th>
			</tr>
			<tr>
				<td>น้องไก่ คนงาม</td>
				<td>ลำพูน</td>
				<td>ไทย</td>
			</tr>
			<tr>
				<td>นายรักเรียน</td>
				<td>Francisco Chang</td>
				<td>Mexico</td>
			</tr>
			<tr>
				<td>นายรักดี</td>
				<td>Roland Mendel</td>
				<td>Austria</td>
			</tr>
		</table>
	</body>
</html>';
// $html = ob_get_contents();  // ทำการเก็บค่า HTML จากคำสั่ง ob_start()

// ob_end_flush();
$mpdf->WriteHTML($html);    // ทำการสร้าง PDF ไฟล์
$mpdf->Output('test.pdf',"I"); // ให้ทำการบันทึกโค้ด HTML เป็น PDF โดยบันทึกเป็นไฟล์ชื่อ MyPDF.pdf
?>