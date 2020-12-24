<?php
include('../condb/condb.php');

$cusCard = $_REQUEST["id"];
$strSQL = "SELECT * FROM tbcustomer WHERE cusCard='$cusCard' ";
$result = mysqli_query($con, $strSQL);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>customer edit</title>
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
</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>
    <div class="container">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h4><b>แก้ไขข้อมูลผู้เช่า</b>
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_customer.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <!-- <a class="text-secondary" style="float: right;" href="../managerData/edit_taxi.php"><i class="fa fa-refresh" aria-hidden="true"></i></a> -->
                    </h4>
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
                <form action="update_customer.php" method="post" enctype="multipart/form-data">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label for="cusCard">รหัสรถแท็กซี่</label>
                            <input type="text" class="form-control" name="cusCard" id="cusCard" value="<?php echo $row['cusCard']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cusName">ชื่อ นามสกุล</label>
                            <input type="text" class="form-control" name="cusName" id="cusName" value="<?php echo $row['cusName']; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cusDriver">เลขที่ใบขับขี่</label>
                            <input type="text" class="form-control" name="cusDriver" id="cusDriver" value="<?php echo $row['cusDriver']; ?>" maxlength="8">
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label for="cusAdd">ที่อยู่</label>
                            <input type="text" class="form-control" name="cusAdd" id="cusAdd" value="<?php echo $row['cusAdd']; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cusTel">เบอร์โทร</label>
                            <input type="text" class="form-control" name="cusTel" id="cusTel" value="<?php echo $row['cusTel']; ?>" maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cusStatus"><b>สถานะ</b></label>
                            <input type="text" class="form-control" name="cusStatus" id="cusStatus" value="<?php echo $row['cusStatus']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="col-md-4">
                            <label for="name" class="control-label"><b>รูปผู้เช่า</b></label>
                            <img src="../images/customer/<?php echo $row['cusPic']; ?>" id="preview" class="img-fluid img-thumbnail" style="width: 240px;height: 240px"><br><br>
                            <input type="file" name="upload" accept="image/*" onchange="preview_image(event)"/>
                        </div>
                    </div>
                    <br>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button type="submit" class="btn btn-outline-success">ตกลง</button>
                            <!-- <button type="reset" class="btn btn-outline-warning">ยกเลิก</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>