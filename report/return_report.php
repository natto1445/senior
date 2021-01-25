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
$select = "SELECT tbreturn.id,tbreturn.retID,tbreturn.recDate,tbreturn.retDate,tbreturn.hirnum,tbcustomer.cusName,tbtaxi.carNum,usrName.tbuser,tbreturn.dateRate,tbreturn.Fines ";
$from   = "FROM tbreturn ";
$join   = "JOIN tbcontract ON tbcontract.hirNum = tbreturn.hirNum JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbreturn.usrID";
$where = [];


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

$order  = "ORDER BY tbreturn.id DESC ";
$limit  = "LIMIT $perPage ";
$offset = "OFFSET $offset ";
$query  = $select.$from.$join.$where.$order.$limit.$offset;

include('../layout/header.php');
?>
<div class="menu">
    <?php include '../layout/menu.php'; ?>
</div>
<div class="container">
    <h4 class="mt-3 mb-3">รายงานรับคืนรถ</h4>
    
    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="hir_report.php">
                <div class="form-row align-items-center">
                    <!--
                    <div class="col-auto">
                        <label class="sr-only" for="search">ค้นหา</label>
                        <input type="text" name="search" class="form-control mb-2" id="search" value="<?php echo $search; ?>" autocomplete="off">
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="start_date">วันเริ่มต้น</label>
                        <input type="date" name="start_date" class="form-control mb-2" id="start_date" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="end_date">วันสิ้นสุด</label>
                        <input type="date" name="end_date" class="form-control mb-2" id="end_date" value="<?php echo $end_date; ?>">
                    </div>
                -->
                    <div class="col-auto">
                        <!-- <button type="submit" class="btn btn-primary mb-2">ค้นหา</button> -->

                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#reportModal">
                            ออกรายงาน
                        </button>
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
                <tbody>
                    <?php
                    if($result = $con->query($query)){
                        while($carReturn = $result->fetch_assoc()){
                        ?>
                        <tr>
                            <td><?php echo $carReturn['id']; ?></td>
                            <td><?php echo $carReturn['retID']; ?></td>
                            <td><?php echo $carReturn['recDate']; ?></td>
                            <td><?php echo $carReturn['retDate']; ?></td>
                            <td><?php echo $carReturn['hirnum']; ?></td>
                            <td><?php echo $carReturn['cusName']; ?></td>
                            <td><?php echo $carReturn['carNum']; ?></td>
                            <td><?php echo $carReturn['usrName']; ?></td>
                            <td><?php echo $carReturn['dateRate']; ?></td>
                            <td><?php echo $carReturn['Fines']; ?></td>
                        </tr>
                        <?php 
                        }
                    }else{
                        ?>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
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
                <h5 class="modal-title">รายงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="return_report_pdf.php<?php echo queryString(['search'=>$search,'start_date'=>$start_date,'end_date'=>$end_date]); ?>" name="report" style="width: 100%;min-height: 600px;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onClick="window.frames['report'].print();">พิมพ์รายงาน</button>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php'); ?>