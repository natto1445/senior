<?php
include('../condb/condb.php');
//Load Establishment list from database
$sql = "SELECT * from tbbrands";
$query = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>generate create</title>
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
                    <h2><b>เพิ่มข้อมูลรุ่นรถ
                            <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_generate.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <a class="text-secondary" style="float: right;" href="../managerData/create_generate.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        </b></h2>
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
                <form action="save_generate.php" method="post">
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="eBrands"><b>ยี่ห้อรถ</b></label>
                            <select style="font-size: 14pt;" size="1" class="form-control" name="eBrands">
                                <option selected disabled value="">-กรุณาเลือกยี่ห้อรถ-</option>
                                <?php while ($brand = mysqli_fetch_assoc($query)) { ?>
                                    <option value="<?php echo $brand["eBrands"] ?>"><?php echo $brand["eBrands"] ?></option>
                                <?php } ?>
                            </select>
                            <br>
                            <label style="font-size: 14pt;" for="generate"><b>รุ่นรถ</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="generate" id="generate" placeholder="รุ่นรถ">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success">ตกลง</button>
                            <button style="font-size: 14pt;" type="reset" class="btn btn-outline-warning">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>