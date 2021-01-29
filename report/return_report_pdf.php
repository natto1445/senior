<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbreturn.id,tbreturn.retID,tbreturn.recDate,tbreturn.retDate,tbreturn.hirNum,tbcustomer.cusName,tbtaxi.carNum,tbuser.usrName,tbreturn.dateRate,tbreturn.Fines ";
$from   = "FROM tbreturn ";
$join   = "LEFT JOIN tbcontract ON tbcontract.hirNum = tbreturn.hirNum LEFT JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard LEFT JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID LEFT JOIN tbuser ON tbuser.usrID = tbreturn.usrID ";
$where = [];

if($search){
    $where[] = " (tbreturn.retID LIKE '%$search%' OR tbuser.usrName LIKE '%$search%') ";
}
if($start_date){
    $where[] = " DATE(tbreturn.retDate) >= '$start_date' ";
}
if($end_date){
    $where[] = " DATE(tbreturn.retDate) <= '$end_date' ";
}
if(count($where)){
    $where = "WHERE ".implode(" AND ", $where);
}else{
    $where = "";
}

$order  = "ORDER BY tbreturn.id DESC ";
$query  = $select.$from.$join.$where.$order;

header("Content-type:application/pdf");
header("Content-disposition: attachment;filename=return_report.pdf");

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
		<h1>รายงานส่งหมอบรถ</h1>
        '.displaySearch($search, $start_date, $end_date).'
		<table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เลขที่รับคืน</th>
                    <th>วันที่ต้องคืน</th>
                    <th>วันที่คืนรถ</th>
                    <th>เลขที่สัญญา</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>ทะเบียนรถที่เช่า</th>
                    <th>ชื่อพนักงาน</th>
                    <th>จำนวนวันคืนช้า</th>
                    <th>ค่าปรับคืนช้า</th>
                </tr>
            </thead>
            <tbody>';
            if( $result = $con->query($query)){
                while($carReturn = $result->fetch_assoc()){
                    $html .= '
                    <tr>
                        <td>'.$carReturn['id'].'</td>
                        <td>'.$carReturn['retID'].'</td>
                        <td>'.$carReturn['recDate'].'</td>
                        <td>'.$carReturn['retDate'].'</td>
                        <td>'.$carReturn['hirNum'].'</td>
                        <td>'.$carReturn['cusName'].'</td>
                        <td>'.$carReturn['carNum'].'</td>
                        <td>'.$carReturn['usrName'].'</td>
                        <td>'.$carReturn['dateRate'].'</td>
                        <td>'.$carReturn['Fines'].'</td>
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
