<?php
include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>report index</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../js/sweetalert.min.js"></script>
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <div class="container">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h4><b>รายงาน</b></h4>
                </div>
                <br>
                <div class="card-columns">
                    <div class="card bg-primary" style="width: 343px; height: 120px" onclick="location.href='hir_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-file-text-o" aria-hidden="true" style="font-size: 2rem; padding-top: 5px;"></i>
                            <p class="card-text" style="padding-top: 5px;"><b>สัญญาเช่า</b></p>
                        </div>
                    </div>
                    <div class="card bg-secondary" style="width: 343px; height: 120px" onclick="location.href='deliver_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-car" aria-hidden="true" style="font-size: 2rem; padding-top: 5px;"></i>
                            <p class="card-text" style="padding-top: 5px;"><b>ส่งมอบรถ</b></p>
                        </div>
                    </div>
                    <div class="card bg-secondary" style="width: 343px; height: 120px" onclick="location.href='return_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-caret-left" aria-hidden="true" style="padding-right: 5px;"></i><i class="fa fa-car" aria-hidden="true" style="font-size: 2rem; padding-top: 5px;"></i>
                            <p class="card-text" style="padding-top: 5px;"><b>รับคืนรถ</b></p>
                        </div>
                    </div>
                </div>

                <div class="card-columns">
                    <div class="card bg-success" style="width: 343px; height: 120px" onclick="location.href='payment_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-cc-visa" aria-hidden="true" style="font-size: 2rem; padding-top: 5px;"></i>
                            <p class="card-text" style="padding-top: 5px;"><b>การชำระเงิน</b></p>
                        </div>
                    </div>
                    <div class="card bg-warning" style="width: 343px; height: 120px" onclick="location.href='repair_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-wrench" aria-hidden="true" style="font-size: 2rem; padding-top: 5px;"></i>
                            <p class="card-text" style="padding-top: 5px;"><b>ส่งซ่อมรถ</b></p>
                        </div>
                    </div>
                    <div class="card bg-warning" style="width: 343px; height: 120px" onclick="location.href='returnrepair_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-caret-left" aria-hidden="true" style="padding-right: 5px;"></i><i class="fa fa-wrench" aria-hidden="true" style="font-size: 2rem; padding-top: 5px;"></i>
                            <p class="card-text" style="padding-top: 5px;"><b>รับรถจากซ่อม</b></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
<?php
include('../includes/scripts.php');
?>