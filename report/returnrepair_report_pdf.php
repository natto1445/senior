<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbreturn_repair.id,tbreturn_repair.returnID,tbreturn_repair.repID,tbrepair.hirNum,tbcustomer.cusName, tbtaxi.carNum,tbrepair.text_repair,tbrepair.price_repair,tbrepair.dateRepair,tbreturn_repair.date_return ";
$from   = "FROM tbreturn_repair ";
$join   = "JOIN tbrepair ON tbrepair.repID = tbreturn_repair.repID JOIN tbcontract ON tbcontract.hirNum = tbrepair.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID ";
$where = [];


if($search){
    $where[] = " (tbreturn_repair.returnID LIKE '%$search%' OR tbtaxi.carNum LIKE '%$search%') ";
}
if($start_date){
    $where[] = " DATE(tbreturn_repair.date_return) >= '$start_date' ";
}
if($end_date){
    $where[] = " DATE(tbreturn_repair.date_return) <= '$end_date' ";
}
if(count($where)){
    $where = "WHERE ".implode(" AND ", $where);
}else{
    $where = "";
}

$order  = "ORDER BY tbreturn_repair.id DESC ";
$query  = $select.$from.$join.$where.$order;

header("Content-type:application/pdf");
header("Content-disposition: attachment;filename=returnrepair_report.pdf");

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
		<h1>รายงานรับคืนรถจากการซ่อม</h1>
		<table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เลขที่รับรถคืน</th>
                    <th>เลขที่ส่งซ่อม</th>
                    <th>เลขที่สัญญา</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>ทะเบียนรถที่เช่า</th>
                    <th>งานซ่อม</th>
                    <th>ราคาซ่อม</th>
                    <th>วันที่ส่งซ่อม</th>
                    <th>วันที่รับคืนจริง</th>
                </tr>
            </thead>
            <tbody>';
            if( $result = $con->query($query)){
                while($reternRepair = $result->fetch_assoc()){
                    $html .= '
                    <tr>
                        <td>'.$reternRepair['id'].'</td>
                        <td>'.$reternRepair['returnID'].'</td>
                        <td>'.$reternRepair['repID'].'</td>
                        <td>'.$reternRepair['hirnum'].'</td>
                        <td>'.$reternRepair['cusName'].'</td>
                        <td>'.$reternRepair['carNum'].'</td>
                        <td>'.$reternRepair['text_repair'].'</td>
                        <td>'.$reternRepair['price_repair'].'</td>
                        <td>'.$reternRepair['dateRepair'].'</td>
                        <td>'.$reternRepair['date_return'].'</td>
                    </tr>';
                }
            }else{
                $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            }
$html .= '</tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('test.pdf',"I");
