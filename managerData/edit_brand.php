<?php 
    include('../condb/condb.php');

    $eBrands = $_REQUEST["id"];
    $strSQL = "SELECT * FROM tbbrands WHERE eBrands='$eBrands' ";
    $result = mysqli_query($con,$strSQL);
    $row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>brand edit</title>
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
            <div class="card-body">
                <div>
                    <h4>แก้ไขข้อมูลยี่ห้อ
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_brand.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <!-- <a class="text-secondary" style="float: right;" href="../managerData/edit_user.php"><i class="fa fa-refresh" aria-hidden="true"></i></a> -->
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
                    <?php  unset($_SESSION['status']); ?>
                <?php endif ?>
                <br>
                <form action="update_brand.php" method="post">
                <div class="form-row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="eBrands">ชื่อแบรนด์ อังกฤษ</label>
                            <input type="text" class="form-control" name="eBrands" id="eBrands" value="<?php echo $row['eBrands'];?>" placeholder="อังกฤษ" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tBrands">ชื่อแบรนด์ ไทย</label>
                            <input type="text" class="form-control" name="tBrands" id="tBrands" value="<?php echo $row['tBrands'];?>" placeholder="ไทย">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button type="submit" class="btn btn-outline-success">อัพเดท</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>