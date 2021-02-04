<?php
include('../condb/condb.php');
$date = date('d-m-Y');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>user report</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/dataTables.bootstrap4.min.css" />
    <script src="../js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="print.css" media="print">
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
            <div class="card-body" style="width: 100%;" id="div_print">
                <div>
                    <h2><b>รายงานข้อมูลรถแท็กซี่</b></h2>
                </div>
                <br>
                <div>
                    <a style="font-size: 14pt;">วันที่ออกรายงาน <?php echo $date ?></a>
                    <br>
                    <br>
                    <?php
                    $query = "SELECT * FROM tbtaxi ORDER BY id ASC";
                    $result = mysqli_query($con, $query);
                    ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <div>
                                <table class="table table-hover" id="example">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th style="width: 5%;  font-size: 14pt;"><b>ลำดับ</b></th>
                                            <th style="width: 7%;  font-size: 14pt;"><b>แบรนด์</b></th>
                                            <th style="width: 7%;  font-size: 14pt;"><b>รุ่น</b></th>
                                            <th style="width: 15%; font-size: 14pt;"><b>เลขทะเบียน</b></th>
                                            <th style="width: 10%; font-size: 14pt;"><b>ปีที่จด</b></th>
                                            <th style="width: 8%;  font-size: 14pt;"><b>ราคา</b></th>
                                            <th style="width: 8%;  font-size: 14pt;"><b>สถานะ</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>
                                                <td style="width: 5%;  font-size: 12pt; text-align: center;"><?php echo $row['id']; ?></td>
                                                <td style="width: 7%;  font-size: 12pt;"><?php echo $row['carBrand']; ?></td>
                                                <td style="width: 7%;  font-size: 12pt;"><?php echo $row['carGen']; ?></td>
                                                <td style="width: 15%; font-size: 12pt;"><?php echo $row['carNum']; ?></td>
                                                <td style="width: 10%; font-size: 12pt;"><?php echo $row['carYN']; ?></td>
                                                <td style="width: 8%;  font-size: 12pt;"><?php echo $row['carRent']; ?></td>
                                                <td style="width: 8%;  font-size: 12pt;"><?php echo $row['carStatus']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                    // mysqli_close($con);
                    ?>
                </div>
            </div>
            <div>
                <div class="card-body">
                    <div class="form-row col-md-2" style="padding-left: 0px;">
                        <div class="form-group col-md-1.5">
                            <button class="btn btn-outline-success float-left" type="button" name="button" id="print" onclick="window.print();"><i class="fa fa-print"></i> ออกรายงาน </button>
                        </div>
                        <div class="form-group col-md-2">
                            <a href="/report/index_report.php" id="return" class="btn btn-outline-primary mb-2">ย้อนกลับ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/jquery.dataTables.min.js"></script>
    <script src="bootstrap/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

</body>

</html>
<?php
include('../includes/scripts.php');
?>