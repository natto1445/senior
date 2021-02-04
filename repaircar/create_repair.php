<?php
include('../condb/condb.php');

//Load Establishment list from database
$sql = "SELECT * FROM tbtaxi WHERE carStatus='มีการซ่อมรถ'";
$repair = mysqli_query($con, $sql);

$sql2 = "SELECT MAX(id) as maxid FROM tbrepair";
$repair2 = mysqli_query($con, $sql2);
$data_repair = mysqli_fetch_array($repair2);

$date = date('Y');
$datenow = date('Y-m-d');

date_default_timezone_set("Asia/Bangkok");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>repair create</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="print.css" media="print">

    <script src="../js/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type='text/javascript'>
        function preview_image(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
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
        <div class="card bg-light text-dark" id="div1">
            <div class="card-body">
                <div>
                    <h2><b>ส่งซ่อมรถ</b>
                        <a class="text-secondary" style="float: right" href="../repaircar/create_repair.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h2>
                </div>

                <!-- แจ้งเตือนสถานะ -->

                <?php if (isset($_SESSION['status'])) : ?>
                    <script>
                        swal({
                            title: "<?php echo $_SESSION['status']; ?>",
                            icon: "<?php echo $_SESSION['status_code']; ?>",
                            button: "OK",
                        });
                    </script>
                    <?php unset($_SESSION['status']); ?>
                <?php endif ?>

                <br>
                <form action="find_repair.php" method="post">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="payID_find"><b>รถแท็กซี่ที่รอซ่อม</b></label>
                            <select style="font-size: 14pt;" size="1" class="form-control" name="payID_find" id="payID_find">
                                <option selected disabled value="">-กรุณาเลือกรถแท็กซี่-</option>
                                <?php while ($data = mysqli_fetch_assoc($repair)) { ?>
                                    <option value="<?php echo $data["payID"] ?>"><?php echo $data["carNum"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label style="font-size: 14pt;" for="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <button style="font-size: 14pt;" type="button" name="submit_find" id="submit_find" class="btn btn-outline-success">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <!-- โหลดข้อมูลรถแท็กซี่ที่ว่าง -->
        <?php if (isset($_SESSION["data_true"])) :
            $data = $_SESSION["data"];
            $sql = "SELECT * FROM tbpayment JOIN tbtaxi ON tbpayment.carID=tbtaxi.carID JOIN tbcustomer ON tbpayment.cusCard=tbcustomer.cusCard JOIN tbuser ON tbpayment.usrId=tbuser.usrID WHERE tbpayment.payID='$data'";
            $query = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($query)) {
        ?>

                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <form action="save_repair.php" method="post">
                            <div>
                                <h2><b>ข้อมูลการส่งซ่อม</b></h2>
                            </div>
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="repID" style="font-size: 14pt;"><b>เลขที่ส่งซ่อม</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="repID" id="repID" value="REP-<?php echo $date ?>-00<?php echo $data_repair['maxid'] + 1 ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrID"] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="hirNum" style="font-size: 14pt;"><b>เลขที่สัญญา</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="hirNum" id="hirNum" value="<?php echo $row['hirNum']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="payID" id="payID" value="<?php echo $row['payID']; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="cusName"><b>ชื่อผู้เช่า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="cusName" id="cusName" value="<?php echo $row['cusName']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="cusCard" id="cusCard" value="<?php echo $row['cusCard']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="usrName"><b>พนักงานรับชำระ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="usrName" id="usrName" value="<?php echo $row['usrName']; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row col-md-12">
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="carNum"><b>ทะเบียนรถ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="carNum" id="carNum" value="<?php echo $row['carNum']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="carID" id="carID" value="<?php echo $row['carID']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="text_rePair"><b>งานซ่อม</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="text_rePair" id="text_rePair" value="<?php echo $row['text_rePair']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="price_rePair"><b>ราคาซ่อมทั้งหมด</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="price_rePair" id="price_rePair" value="<?php echo $row['price_rePair'] * 2; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="dateRepair"><b>วันที่ส่งซ่อม</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="dateRepair" id="dateRepair" value="<?php echo $datenow ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="dateSuc"><b>วันที่คาดว่าจะได้รับ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="dateSuc" id="dateSuc" value="<?php echo date('Y-m-d', strtotime("+5 day")); ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row col-md-12">
                                <div class="form-group col-md-5">
                                    <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success" id="btn1">ส่งซ่อม</button>
                                    <button style="font-size: 14pt;" class="btn btn-outline-success" type="button" name="button" id="print" onclick="window.print();"><i class="fa fa-print"></i> พิมพ์ </button>
                                    <a style="font-size: 14pt;" class="btn btn-outline-danger" href="../repaircar/create_repair.php" id="btn2">ยกเลิก</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php unset($_SESSION["data_true"]) ?>
        <?php }
        endif ?>

        <!-- check select carNum_find -->

        <script>
            $(document).ready(function() {
                $('#submit_find').on('click', function() {
                    var contract = $('#carNum_find option:selected').text();
                    if (contract == "-กรุณาเลือกรถแท็กซี่-") {
                        swal({
                            title: "กรุณาเลือกรถแท็กซี่",
                            icon: "info",
                            button: "OK",
                        });
                    } else {
                        $('button[name="submit_find"]').prop("type", "submit");
                    }
                });
            });
        </script>

</body>

</html>