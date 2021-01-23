<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbcontract.*,tbcustomer.cusName,tbuser.usrName,tbtaxi.carNum ";
$from   = "FROM tbcontract ";
$join   = "JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID ";
$where = [];
if($start_date){
    $where[] = " DATE(tbcontract.hirStart) >= '$start_date' ";
}
if($end_date){
    $where[] = " DATE(tbcontract.hirEnd) <= '$end_date' ";
}
if(count($where)){
    $where = "WHERE ".implode(" AND ", $where);
}else{
    $where = "";
}

$order  = "ORDER BY tbcontract.id DESC ";
$query  = $select.$from.$join.$where.$order;

header("Content-type:application/pdf");
header("Content-disposition: attachment;filename=YOURFILE.pdf");

$mpdf = new \Mpdf\Mpdf();
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
		<h1>รายงานสัญญาเช่า</h1>
		<table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>เลขสัญญา</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>วันที่เริ่ม</th>
                    <th>วันที่สิ้นสุด</th>
                    <th>ชื่อพนักงาน</th>
                    <th>ทะเบียนรถ</th>
                    <th>ราคารถ</th>
                    <th>จำนวนวัน</th>
                </tr>
            </thead>
            <tbody>';
$result = $con->query($query);
while($contract = $result->fetch_assoc()){
    $html .= '
    <tr>
        <td>'.$contract['id'].'</td>
        <td>'.$contract['hirNum'].'</td>
        <td>'.$contract['cusName'].'</td>
        <td>'.$contract['hirStart'].'</td>
        <td>'.$contract['hirEnd'].'</td>
        <td>'.$contract['usrName'].'</td>
        <td>'.$contract['carNum'].'</td>
        <td>'.$contract['carRent'].'</td>
        <td>'.$contract['numDay'].'</td>
    </tr>';
}
$html .= '</tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('test.pdf',"I");