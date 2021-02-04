<?php 
include('../condb/condb.php');
include('../includes/helper.php');
include('../layout/header.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');
$page       = request('page', 1);

$perPage = 10;
$offset = ($page-1) * $perPage;

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
$limit  = "LIMIT $perPage ";
$offset = "OFFSET $offset ";
$query  = $select.$from.$join.$where.$order.$limit.$offset;

include('../layout/header.php');
?>
<div class="menu">
    <?php include '../layout/menu.php'; ?>
</div>
<div style="width: 80%;" class="center_div">
    <h2 class="mt-3 mb-3">รายงานชำระเงิน</h2>
    
    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="payment_report.php">
                <div class="form-row align-items-center">
                    
                    <div class="col-auto">
                        <label style="font-size: 14pt;" class="sr-only" for="search">ค้นหา</label>
                        <input style="font-size: 14pt;" type="text" name="search" class="form-control mb-2" id="search" value="<?php echo $search; ?>" autocomplete="off">
                    </div>
                    <div class="col-auto">
                        <label style="font-size: 14pt;" class="sr-only" for="start_date">วันเริ่มต้น</label>
                        <input style="font-size: 14pt;" type="date" name="start_date" class="form-control mb-2" id="start_date" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-auto">
                        <label style="font-size: 14pt;" class="sr-only" for="end_date">วันสิ้นสุด</label>
                        <input style="font-size: 14pt;" type="date" name="end_date" class="form-control mb-2" id="end_date" value="<?php echo $end_date; ?>">
                    </div>
                    
                    <div class="col-auto">
                        <button style="font-size: 14pt;" type="submit" class="btn btn-primary mb-2">ค้นหา</button>

                        <button style="font-size: 14pt;" type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#reportModal">
                            ออกรายงาน
                        </button>
                        <a style="font-size: 14pt;" href="/report/payment_report.php" class="btn btn-primary mb-2">รีเฟรช</a>
                        <a style="font-size: 14pt;" href="/report/index_report.php" class="btn btn-primary mb-2">ย้อนกลับ</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="font-size: 16pt;">ลำดับ</th>
                        <th style="font-size: 16pt;">เลขที่ชำระเงิน</th>
                        <th style="font-size: 16pt;">เลขที่สัญญา</th>
                        <th style="font-size: 16pt;">วันที่ชำระ</th>
                        <th style="font-size: 16pt;">ชื่อผู้เช่า</th>
                        <th style="font-size: 16pt;">ทะเบียนรถที่เช่า</th>
                        <th style="font-size: 16pt;">จำนวนวันที่เช่า</th>
                        <th style="font-size: 16pt;">ค่าปรับคืนช้า</th>
                        <th style="font-size: 16pt;">การซ่อม</th>
                        <th style="font-size: 16pt;">ราคาซ่อม</th>
                        <th style="font-size: 16pt;">รวมค่าเช่าสุทธิ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result = $con->query($query)){
                        while($payment = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td style="font-size: 14pt; text-align: center;"><?php echo $payment['id']; ?></td> 
                            <td style="font-size: 14pt;"><?php echo $payment['payID']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['hirnum']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['date_payment']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['cusName']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['carNum']; ?></td>
                            <td style="font-size: 14pt; text-align: center;"><?php echo $payment['numDay']; ?></td>
                            <td style="font-size: 14pt; text-align: right;"><?php echo $payment['Fines']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['repair']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['price_repair']; ?></td>
                            <td style="font-size: 14pt;"><?php echo $payment['total2']; ?></td>
                        </tr>
                        <?php 
                        }
                    }else{
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

            <?php 
            // Pagination 
            
            $select = "SELECT count(*) as total ";
            $query  = $select.$from.$join.$where;
            $result = $con->query($query); // ดึงจำนวนแถวทั้งหมด
            $row    = mysqli_fetch_object($result);
            $total  = $row->total;

            $lastPage = 1;
            $max = (int) ceil($total / $perPage);
            if($max > 1){
                $lastPage = $max;
            }
            $hasPages = $lastPage > 1;
            $onFirstPage = $page <= 1;
            $hasMorePages = $page < $lastPage;

            if($hasPages){
            ?>
                <ul class="pagination">
                    <?php 
                    if($onFirstPage){
                    ?>
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    <?php 
                    }else{
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo queryString(['page'=>($page-1),'search'=>$search,'start_date'=>$start_date,'end_date'=>$end_date]); ?>" rel="prev">&laquo;</a>
                        </li>
                    <?php 
                    }

                    foreach (range(1, $lastPage) as $pagerang) {
                        if($page == $pagerang){
                        ?>
                            <li class="page-item active"><span class="page-link"><?php echo $page; ?></span></li>
                        <?php
                        }else{
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo queryString(['page'=>$pagerang,'search'=>$search,'start_date'=>$start_date,'end_date'=>$end_date]); ?>"><?php echo $pagerang; ?></a>
                            </li>
                        <?php
                        }
                    }

                    if($hasMorePages){
                    ?>
                        <li class="page-item"><a class="page-link" href="<?php echo queryString(['page'=>($page+1),'search'=>$search,'start_date'=>$start_date,'end_date'=>$end_date]); ?>" rel="next">&raquo;</a></li>
                    <?php 
                }else{
                    ?>
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    <?php 
                    } 
                    ?>
                </ul>
            <?php   
            }
            ?>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reportModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายงานชำระเงิน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="payment_report_pdf.php<?php echo queryString(['search'=>$search,'start_date'=>$start_date,'end_date'=>$end_date]); ?>" name="report" style="width: 100%;min-height: 600px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onClick="window.frames['report'].print();">พิมพ์รายงาน</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .center_div {
        margin: auto;
    }
</style>

<?php include('../layout/footer.php'); ?>