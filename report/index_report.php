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

    <style type="text/css">
        .center_div {
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <div style="width: 80%;" class="center_div">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h2><b>รายงาน</b></h2>
                </div>
                <br>
                <div class="card-columns">
                    <div class="card bg-primary" style="width: 100%; height: 220px" onclick="location.href='hir_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-file-text-o" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>สัญญาเช่า</h4></b></p>
                        </div>
                    </div>
                    <div class="card bg-secondary" style="width: 100%; height: 220px" onclick="location.href='deliver_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-car" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>ส่งมอบรถ</h4></b></p>
                        </div>
                    </div>
                    <div class="card bg-secondary" style="width: 100%; height: 220px" onclick="location.href='return_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-caret-left" aria-hidden="true" style="padding-right: 5px;"></i><i class="fa fa-car" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>รับรถคืน</h4></b></p>
                        </div>
                    </div>
                </div>

                <div class="card-columns">
                    <div class="card bg-success" style="width: 100%; height: 220px" onclick="location.href='payment_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-cc-visa" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>ชำระเงิน</h4></b></p>
                        </div>
                    </div>
                    <div class="card bg-warning" style="width: 100%; height: 220px" onclick="location.href='repair_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-wrench" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>ส่งซ่อมรถ</h4></b></p>
                        </div>
                    </div>
                    <div class="card bg-warning" style="width: 100%; height: 220px" onclick="location.href='returnrepair_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-caret-left" aria-hidden="true" style="padding-right: 5px;"></i><i class="fa fa-wrench" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>รับคืนจากซ่อม</h4></b></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;">
                <div>
                    <h2><b>รายงาน ข้อมูลพื้นฐาน</b></h2>
                </div>
                <br>
                <div class="card-columns">
                    <div class="card bg-secondary" style="width: 100%; height: 220px" onclick="location.href='user_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-user" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>ข้อมูลพนักงาน</h4></b></p>
                        </div>
                    </div>
                    <div class="card bg-secondary" style="width: 100%; height: 220px" onclick="location.href='car_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-car" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>ข้อมูลรถแท็กซี่</h4></b></p>
                        </div>
                    </div>
                    <div class="card bg-secondary" style="width: 100%; height: 220px" onclick="location.href='customer_report.php';" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <i class="fa fa-users" aria-hidden="true" style="font-size: 3rem; padding-top: 50px;"></i>
                            <p class="card-text" style="padding-top: 1px;"><b><h4>ข้อมูลผู้เช่า</h4></b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</body>

</html>
<?php
include('../includes/scripts.php');
?>