<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbdelivers.id,tbdelivers.delID,tbdelivers.delDate,tbdelivers.hirNum,tbcustomer.cusName,tbtaxi.carNum,tbuser.usrName ";
$from   = "FROM tbdelivers ";
$join   = "JOIN tbcontract ON tbcontract.hirNum = tbdelivers.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbdelivers.usrID";
$where = [];
// ชื่อพนักงาน tbuser.usrName เลขที่สัญญา tbcontract.hirNum เลขที่ชำระเงิน เลขที่ส่งซ่อม
if($search){
    $where[] = " (tbuser.usrName LIKE '%$search%' OR tbcontract.hirNum LIKE '%$search%') ";
}
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
		<h1>รายงานสัญญาเช่า</h1>
		<table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เลขที่ส่งมอบ</th>
                    <th>วันที่ส่งมอบ</th>
                    <th>เลขที่สัญญา</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>ทะเบียนรถที่เช่า</th>
                    <th>ชื่อพนักงาน</th>
                </tr>
            </thead>
            <tbody>';
            if( $result = $con->query($query)){
                while($contract = $result->fetch_assoc()){
                    $html .= '
                    <tr>
                        <td>'.$deliver['id'].'</td>
                        <td>'.$deliver['delID'].'</td>
                        <td>'.$deliver['delDate'].'</td>
                        <td>'.$deliver['hirnum'].'</td>
                        <td>'.$deliver['cusName'].'</td>
                        <td>'.$deliver['carNum'].'</td>
                        <td>'.$deliver['usrName'].'</td>
                    </tr>';
                }
            }else{
                $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            }
$html .= '</tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('test.pdf',"I");