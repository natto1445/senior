<?php
include('../condb/condb.php');
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
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <div class="container">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body" style="width: 100%;" id="div_print">
                <div>
                    <h4><b>รายงานข้อมูลรถแท็กซี่</b></h4>
                </div>
                <br>
                <div>
                    <?php
                    $query = "SELECT * FROM tbtaxi ORDER BY id ASC";
                    $result = mysqli_query($con, $query);
                    ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <div>
                                <table class="table-borderless" id="example">
                                    <thead style="text-align: center;">
                                        <tr>
                                            <th style="width: 5%;"><b>ลำดับ</b></th>
                                            <th style="width: 10%;"><b>รหัสรถแท็กซี่</b></th>
                                            <th style="width: 7%;"><b>แบรนด์</b></th>
                                            <th style="width: 7%;"><b>รุ่น</b></th>
                                            <th style="width: 15%;"><b>หมายเลขทะเบียน</b></th>
                                            <th style="width: 10%;"><b>ปีจดทะเบียน</b></th>
                                            <th style="width: 8%;"><b>ราคาเช่า</b></th>
                                            <th style="width: 8%;"><b>สถานะ</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr>
                                                <td style="width: 5%;"><?php echo $row['id']; ?></td>
                                                <td style="width: 10%;"><?php echo $row['carID']; ?></td>
                                                <td style="width: 7%;"><?php echo $row['carBrand']; ?></td>
                                                <td style="width: 7%;"><?php echo $row['carGen']; ?></td>
                                                <td style="width: 15%;"><?php echo $row['carNum']; ?></td>
                                                <td style="width: 10%;"><?php echo $row['carYN']; ?></td>
                                                <td style="width: 8%;"><?php echo $row['carRent']; ?></td>
                                                <td style="width: 8%;"><?php echo $row['carStatus']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php
                    // mysqli_close($con);
                    ?>
                </div>
            </div>
            <div>
                <div class="card-body">
                    <button onClick="printdiv('div_print');" id="print" class="btn btn-success float-left"><i class="fa fa-print"></i> ออกรายงาน</button>
                </div>
            </div>
            <br>
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
    <script language="javascript">
        function printdiv(printpage) {
            document.getElementById('example_length').style.display = 'none';
            document.getElementById('example_filter').style.display = 'none';
            document.getElementById('example_info').style.display = 'none';
            document.getElementById('example_paginate').style.display = 'none';
            var headstr = "<html><head><title></title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            w = window.open("", "_blank", "k");
            w.document.write(headstr + newstr + footstr);
            w.print();
            document.body.innerHTML = oldstr;
            location.reload();
            console.log(newstr);
            return false;
        }
    </script>

</body>

</html>
<?php
include('../includes/scripts.php');
?>