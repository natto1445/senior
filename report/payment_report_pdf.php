<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../vendor/autoload.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');

// ดึงข้อมูล
$select = "SELECT tbpayment.id,tbpayment.payID,tbpayment.hirnum,tbcustomer.cusName,tbtaxi.carNum,tbpayment.numDay,tbpayment.date_payment,tbpayment.Fines,tbpayment.repair,tbpayment.price_repair,tbpayment.total2 ";
$from   = "FROM tbpayment ";
$join   = "JOIN tbcontract ON tbcontract.hirNum = tbpayment.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID LEFT JOIN tbuser ON tbuser.usrID = tbpayment.usrID ";
$where = [];
if($search){
    $where[] = " (tbpayment.payID LIKE '%$search%' OR tbuser.usrName LIKE '%$search%') ";
}
if($start_date){
    $where[] = " DATE(tbpayment.date_payment) >= '$start_date' ";
}
if($end_date){
    $where[] = " DATE(tbpayment.date_payment) <= '$end_date' ";
}
if(count($where)){
    $where = "WHERE ".implode(" AND ", $where);
}else{
    $where = "";
}

$order  = "ORDER BY tbpayment.id DESC ";
$query  = $select.$from.$join.$where.$order;

header("Content-type:application/pdf");
header("Content-disposition: attachment;filename=payment_report.pdf");

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
		<h1>รายงานชำระเงิน</h1>
        <div>
            <div class="left">'.displaySearch($search, $start_date, $end_date).'</div>
            <div class="right">วันที่ออกรายงาน '.date('d-m-Y').'</div>
        </div>
		<table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>เลขที่ชำระเงิน</th>
                    <th>เลขที่สัญญา</th>
                    <th>วันที่ชำระ</th>
                    <th>ชื่อผู้เช่า</th>
                    <th>ทะเบียนรถที่เช่า</th>
                    <th>จำนวนวันที่เช่า</th>
                    <th>ค่าปรับคืนช้า</th>
                    <th>การซ่อม</th>
                    <th>ราคาซ่อม</th>
                    <th>รวมค่าเช่าสุทธิ</th>
                </tr>
            </thead>
            <tbody>';
            if( $result = $con->query($query)){
                while($payment = $result->fetch_assoc()){
                    $html .= '
                    <tr>
                        <td>'.$payment['id'].'</td>
                        <td>'.$payment['payID'].'</td>
                        <td>'.$payment['hirnum'].'</td>
                        <td>'.$payment['date_payment'].'</td>
                        <td>'.$payment['cusName'].'</td>
                        <td>'.$payment['carNum'].'</td>
                        <td>'.$payment['numDay'].'</td>
                        <td>'.$payment['Fines'].'</td>
                        <td>'.$payment['repair'].'</td>
                        <td>'.$payment['price_repair'].'</td>
                        <td>'.$payment['total2'].'</td>
                    </tr>';
                }
            }else{
                $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            }

            $sum_price_repair = 0;
            $sum_total2 = 0;

            $select = "SELECT SUM(tbpayment.price_repair) as sum_price_repair ";
            $query  = $select.$from.$join.$where;
            $result = $con->query($query); // ดึงจำนวนแถวทั้งหมด
            $row    = mysqli_fetch_object($result);
            $sum_price_repair  = $row->sum_price_repair;

            $select = "SELECT SUM(tbpayment.total2) as sum_total2 ";
            $query  = $select.$from.$join.$where;
            $result = $con->query($query); // ดึงจำนวนแถวทั้งหมด
            $row    = mysqli_fetch_object($result);
            $sum_total2  = $row->sum_total2;

            $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>'.$sum_price_repair.'</td><td>'.$sum_total2.'</td></tr>';
$html .= '</tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('test.pdf',"I");
