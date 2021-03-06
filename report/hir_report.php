<?php
include('../condb/condb.php');
include('../includes/helper.php');
include('../layout/header.php');

$search     = request('search');
$start_date = request('start_date');
$end_date   = request('end_date');
$page       = request('page', 1);

$perPage = 10;
$offset = ($page - 1) * $perPage;

// ดึงข้อมูล
$select = "SELECT tbcontract.*,tbcustomer.cusName,tbuser.usrName,tbtaxi.carNum ";
$from   = "FROM tbcontract ";
$join   = "JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID ";
$where = [];

// ชื่อพนักงาน tbuser.usrName เลขที่สัญญา tbcontract.hirNum เลขที่ชำระเงิน เลขที่ส่งซ่อม
if ($search) {
    $where[] = " (tbuser.usrName LIKE '%$search%' OR tbcontract.hirNum LIKE '%$search%' OR tbcontract.hirStatus LIKE '%$search%') ";
}
if ($start_date) {
    $where[] = " DATE(tbcontract.hirStart) >= '$start_date' ";
}
if ($end_date) {
    $where[] = " DATE(tbcontract.hirEnd) <= '$end_date' ";
}

if (count($where)) {
    $where = "WHERE " . implode(" AND ", $where);
} else {
    $where = "";
}

$order  = "ORDER BY tbcontract.id DESC ";
$limit  = "LIMIT $perPage ";
$offset = "OFFSET $offset ";
$query  = $select . $from . $join . $where . $order . $limit . $offset;

include('../layout/header.php');
?>
<div class="menu">
    <?php include '../layout/menu.php'; ?>
</div>
<div style="width: 80%;" class="center_div">
    <h2 class="mt-3 mb-3">รายงานสัญญาเช่า</h2>
    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="hir_report.php">
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

                        <a style="font-size: 14pt;" href="/report/hir_report.php" class="btn btn-primary mb-2">รีเฟรช</a>
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
                        <th style="font-size: 16pt;">เลขที่สัญญา</th>
                        <th style="font-size: 16pt;">ชื่อผู้เช่า</th>
                        <th style="font-size: 16pt;">วันที่ทำสัญญา</th>
                        <th style="font-size: 16pt;">รูปแบบการเช่า</th>
                        <th style="font-size: 16pt;">ชื่อพนักงาน</th>
                        <th style="font-size: 16pt;">ทะเบียนรถที่เช่า</th>
                        <th style="font-size: 16pt;">จำนวนวัน</th>
                        <th style="font-size: 16pt;">ราคาเช่า</th>
                        <th style="font-size: 16pt;">สถานะสัญญา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row_cnt = 0;
                    if ($result = $con->query($query)) {
                        $row_cnt = mysqli_num_rows($result);
                        while ($contract = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td style="width: 5px; text-align:center; font-size: 14pt;"><?php echo $contract['id']; ?></td>
                                <td style="width: 160px; font-size: 14pt;"><?php echo $contract['hirNum']; ?></td>
                                <td style="width: 200px; font-size: 14pt;"><?php echo $contract['cusName']; ?></td>
                                <td style="font-size: 14pt;"><?php echo $contract['hirDate']; ?></td>
                                <td style="font-size: 14pt; text-align: center;"><?php echo $contract['hirPattern']; ?></td>
                                <td style="font-size: 14pt;"><?php echo $contract['usrName']; ?></td>
                                <td style="font-size: 14pt;"><?php echo $contract['carNum']; ?></td>
                                <td style="text-align:center;"><?php echo $contract['numDay']; ?></td>
                                <td style="font-size: 14pt; text-align:center;"><?php echo ($contract['hirDeposit'] * 2); ?></td>
                                <td style="font-size: 14pt; text-align: center;"><?php echo $contract['hirStatus']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

            <?php
            // Pagination 

            $select = "SELECT count(*) as total ";
            $query  = $select . $from . $join . $where;
            $result = $con->query($query); // ดึงจำนวนแถวทั้งหมด
            $row    = mysqli_fetch_object($result);
            $total  = $row->total;

            $lastPage = 1;
            $max = (int) ceil($total / $perPage);
            if ($max > 1) {
                $lastPage = $max;
            }
            $hasPages = $lastPage > 1;
            $onFirstPage = $page <= 1;
            $hasMorePages = $page < $lastPage;

            if ($hasPages) {
            ?>
                <ul class="pagination">
                    <?php
                    if ($onFirstPage) {
                    ?>
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo queryString(['page' => ($page - 1), 'search' => $search, 'start_date' => $start_date, 'end_date' => $end_date]); ?>" rel="prev">&laquo;</a>
                        </li>
                        <?php
                    }

                    foreach (range(1, $lastPage) as $pagerang) {
                        if ($page == $pagerang) {
                        ?>
                            <li class="page-item active"><span class="page-link"><?php echo $page; ?></span></li>
                        <?php
                        } else {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="<?php echo queryString(['page' => $pagerang, 'search' => $search, 'start_date' => $start_date, 'end_date' => $end_date]); ?>"><?php echo $pagerang; ?></a>
                            </li>
                        <?php
                        }
                    }

                    if ($hasMorePages) {
                        ?>
                        <li class="page-item"><a class="page-link" href="<?php echo queryString(['page' => ($page + 1), 'search' => $search, 'start_date' => $start_date, 'end_date' => $end_date]); ?>" rel="next">&raquo;</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    <?php
                    }
                    ?>
                </ul>

                
            <?php
            }
            ?>
            <span>แสดง <?php echo $row_cnt; ?> รายการจากทั้งหมด <?php echo $total; ?> รายการ</span>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reportModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายงานสัญญาเช่า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="hir_report_pdf.php<?php echo queryString(['search' => $search, 'start_date' => $start_date, 'end_date' => $end_date]); ?>" name="report" style="width: 100%;min-height: 600px;"></iframe>
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