<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbcontract.*,tbcustomer.cusName,tbuser.usrName,tbtaxi.carNum ";
$from   = "FROM tbcontract ";
$join   = "JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID ";
$where = [];

if($search){
    $where[] = " (tbuser.usrName LIKE '%$search%' OR tbcontract.hirNum LIKE '%$search%' OR tbcontract.hirStatus LIKE '%$search%') ";
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
header("Content-disposition: attachment;filename=contract_report.pdf");

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
        .left{
            display:inline-block;
            float:left;
            width:500px;
        }
        .right{
            display:inline-block;
            float:right;
            width:150px;
            text-align:right;
        }
		</style>
	</head>
	<body>
		<h1>รายงานสัญญาเช่า</h1>
        <div>
            <div class="left">'.displaySearch($search, $start_date, $end_date).'</div>
            <div class="right">วันที่ออกรายงาน '.date('d-m-Y').'</div>
        </div>
		<table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เลขที่สัญญา</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>วันที่ทำสัญญา</th>
                    <th>วันที่เริ่มเช่า</th>
                    <th>วันที่สิ้นสุดการเช่า</th>
                    <th>รูปแบบการเช่า</th>
                    <th>ชื่อพนักงาน</th>
                    <th>ทะเบียนรถที่เช่า</th>
                    <th>จำนวนวันที่เช่า</th>
                    <th>ราคาเช่าทั้งหมด</th>
                    <th>สถานะสัญญา</th>
                </tr>
            </thead>
            <tbody>';
if($result = $con->query($query)){
    while($contract = $result->fetch_assoc()){
        $html .= '
        <tr>
            <td>'.$contract['id'].'</td>
            <td>'.$contract['hirNum'].'</td>
            <td>'.$contract['cusName'].'</td>
            <td>'.$contract['hirDate'].'</td>
            <td>'.$contract['hirStart'].'</td>
            <td>'.$contract['hirEnd'].'</td>
            <td>'.$contract['hirPattern'].'</td>
            <td>'.$contract['usrName'].'</td>
            <td>'.$contract['carNum'].'</td>
            <td>'.$contract['numDay'].'</td>
            <td>'.($contract['hirDeposit']*2).'</td>
            <td>'.$contract['hirStatus'].'</td>
        </tr>';
    }
}else{
    $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
}
$html .= '</tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('test.pdf',"I");
