<?php 
include('../includes/helper.php');
include('../layout/header.php');

$pdo = new DB();

$start_date = request('start_date');
$end_date   = request('end_date');
$page       = request('page', 1);

$perPage = 10;
$offset = ($page-1) * $perPage;

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
$limit  = "LIMIT $perPage ";
$offset = "OFFSET $offset ";
$sql    = $select.$from.$join.$where.$order.$limit.$offset;
$contracts = $pdo->query($sql)->get();

// ดึงจำนวนแถวทั้งหมด
$select = "SELECT count(*) as aggregate ";
$sql    = $select.$from.$join.$where;
$total  = $pdo->query($sql)->count();

$lastPage = 1;
$max = (int) ceil($total / $perPage);
if($max > 1){
    $lastPage = $max;
}
$hasPages = $lastPage > 1;
$onFirstPage = $page <= 1;
$hasMorePages = $page < $lastPage;

?>
<div class="menu">
    <?php include '../login/menu.php'; ?>
</div>
<div class="container">
    <h4 class="mt-3 mb-3">รายงานสัญญาเช่า</h4>
    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="hir_report.php">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="sr-only" for="start_date">วันเริ่มต้น</label>
                        <input type="date" name="start_date" class="form-control mb-2" id="start_date" value="<?php echo $start_date; ?>">
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="end_date">วันสิ้นสุด</label>
                        <input type="date" name="end_date" class="form-control mb-2" id="end_date" value="<?php echo $end_date; ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">ค้นหา</button>

                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#staticBackdrop">
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
                <tbody>
                    <?php 
                    foreach($contracts as $contract){
                    ?>
                    <tr>
                        <td><?php echo $contract->id; ?></td>
                        <td><?php echo $contract->hirNum; ?></td>
                        <td><?php echo $contract->cusName; ?></td>
                        <td><?php echo $contract->hirStart; ?></td>
                        <td><?php echo $contract->hirEnd; ?></td>
                        <td><?php echo $contract->usrName; ?></td>
                        <td><?php echo $contract->carNum; ?></td>
                        <td><?php echo $contract->carRent; ?></td>
                        <td><?php echo $contract->numDay; ?></td>
                    </tr>
                    <?php 
                    }
                    ?>
                </tbody>
            </table>

            <?php 
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
                            <a class="page-link" href="<?php echo queryString(['page'=>($page-1),'start_date'=>$start_date,'end_date'=>$end_date]); ?>" rel="prev">&laquo;</a>
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
                            <li class="page-item"><a class="page-link" href="<?php echo queryString(['page'=>$pagerang,'start_date'=>$start_date,'end_date'=>$end_date]); ?>"><?php echo $pagerang; ?></a></li>
                        <?php
                        }
                    }

                    if($hasMorePages){
                    ?>
                        <li class="page-item"><a class="page-link" href="<?php echo queryString(['page'=>($page+1),'start_date'=>$start_date,'end_date'=>$end_date]); ?>" rel="next">&raquo;</a></li>
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
                        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <iframe src="/contract/ContractReport.pdf" title="report" style="width: 100%;min-height: 450px;"></iframe>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary">พิมพ์รายงาน</button>
                              </div>
                            </div>
                          </div>
                        </div>
<?php include('../layout/footer.php'); ?>