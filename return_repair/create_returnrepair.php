<?php
include('../condb/condb.php');

$repID = $_REQUEST["id"];
$strSQL = "SELECT * FROM tbrepair JOIN tbtaxi ON tbrepair.carID=tbtaxi.carID WHERE repID='$repID' ";
$result = mysqli_query($con, $strSQL);
$row = mysqli_fetch_array($result);

$sql2 = "SELECT MAX(id) as maxid FROM tbreturn_repair";
$return = mysqli_query($con, $sql2);
$data_return = mysqli_fetch_array($return);

$date = date('Y');
$datenow = date('Y-m-d');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>create returnrepair</title>
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
            <div class="card-body">
                <div>
                    <h2><b>ตรวจสอบข้อมูลเพื่อรับคืน</b>
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_taxi.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <!-- <a class="text-secondary" style="float: right;" href="../managerData/edit_taxi.php"><i class="fa fa-refresh" aria-hidden="true"></i></a> -->
                    </h2>
                </div>
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
                <form action="save_returnrepair.php" method="post" enctype="multipart/form-data">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="retID"><b>เลขที่รับคืน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="retID" id="retID" value="RET-<?php echo $date ?>-00<?php echo $data_return['maxid'] + 1 ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="repID"><b>เลขที่ส่งซ่อม</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="repID" id="repID" value="<?php echo $repID ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="hirNum"><b>เลขที่สัญญาเช่า</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirNum" id="hirNum" value="<?php echo $row['hirNum']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carNum"><b>เลขทะเบียน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carNum" id="carNum" value="<?php echo $row['carNum']; ?>" readonly>
                            <input style="font-size: 14pt;" type="hidden" class="form-control" name="carID" id="carID" value="<?php echo $row['carID']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="text_rePair"><b>รายการซ่อม</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="text_rePair" id="text_rePair" value="<?php echo $row['text_rePair']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="price_rePair"><b>ราคาซ่อม</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="price_rePair" id="price_rePair" value="<?php echo $row['price_rePair']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="dateRepair"><b>วันที่ส่งซ่อม</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="dateRepair" id="dateRepair" placeholder="ราคา" value="<?php echo $row['dateRepair']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="datenow"><b>วันที่รับคืน</b></label>
                            <input style="font-size: 14pt;" type="date" class="form-control" name="datenow" id="datenow" placeholder="ราคา" value="<?php echo $datenow ?>">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="col-md-4">
                            <label style="font-size: 14pt;" for="name" class="control-label"><b>รูปรถแท็กซี่</b></label>
                            <img src="../images/taxi/<?php echo $row['carPic']; ?>" id="preview" class="img-fluid img-thumbnail" style="width: 280px;height: 240px"><br><br>
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success">ตกลง</button>
                            <a style="font-size: 14pt;" class="btn btn-outline-danger" href="../return_repair/index_returnrepair.php"> ยกเลิก </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
</body>

</html>