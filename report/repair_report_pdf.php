<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbrepair.id,tbrepair.repID,tbuser.usrName,tbrepair.hirNum,tbcustomer.cusName,tbtaxi.carNum,tbrepair.text_repair,tbrepair.price_repair,tbrepair.dateRepair, tbrepair.dateSuc,tbrepair.repair_status ";
$from   = "FROM tbrepair ";
$join   = "LEFT JOIN tbcontract ON tbcontract.hirNum = tbrepair.hirNum LEFT JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard LEFT JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID LEFT JOIN tbuser ON tbuser.usrID = tbrepair.usrID ";
$where = [];

if($search){
    $where[] = " (tbrepair.repID LIKE '%$search%' OR tbuser.usrName LIKE '%$search%') ";
}
if($start_date){
    $where[] = " DATE(tbrepair.dateRepair) >= '$start_date' ";
}
if($end_date){
    $where[] = " DATE(tbrepair.dateRepair) <= '$end_date' ";
}
if(count($where)){
    $where = "WHERE ".implode(" AND ", $where);
}else{
    $where = "";
}

$order  = "ORDER BY tbrepair.id DESC ";
$query  = $select.$from.$join.$where.$order;

header("Content-type:application/pdf");
header("Content-disposition: attachment;filename=repair_report.pdf");

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '../tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);
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
		<h1>รายงานส่งซ่อมรถ</h1>
		<table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เลขที่ส่งซ่อม</th>
                    <th>ชื่อพนักงาน</th>
                    <th>เลขที่สัญญา</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>ทะเบียนรถที่เช่า</th>
                    <th>งานซ่อม</th>
                    <th>ราคาซ่อม</th>
                    <th>วันที่ส่งซ่อม</th>
                    <th>วันที่คาดว่าจะได้รถ</th>
                    <th>สถานการณ์ซ่อม</th>
                </tr>
            </thead>
            <tbody>';
            if( $result = $con->query($query)){
                while($payment = $result->fetch_assoc()){
                    $html .= '
                    <tr>
                        <td>'.$payment['id'].'</td>
                        <td>'.$payment['repID'].'</td>
                        <td>'.$payment['usrName'].'</td>
                        <td>'.$payment['hirNum'].'</td>
                        <td>'.$payment['cusName'].'</td>
                        <td>'.$payment['carNum'].'</td>
                        <td>'.$payment['text_repair'].'</td>
                        <td>'.$payment['price_repair'].'</td>
                        <td>'.$payment['dateRepair'].'</td>
                        <td>'.$payment['dateSuc'].'</td>
                        <td>'.$payment['repair_status'].'</td>
                    </tr>';
                }
            }else{
                $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            }
$html .= '</tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('test.pdf',"I");
