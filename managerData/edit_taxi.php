<?php
include('../condb/condb.php');

$carID = $_REQUEST["id"];
$strSQL = "SELECT * FROM tbtaxi WHERE carID='$carID' ";
$result = mysqli_query($con, $strSQL);
$row = mysqli_fetch_array($result);

$sql = "SELECT * from tbbrands";
$brand = mysqli_query($con, $sql);

$sql = "SELECT * from tbgenerate";
$gen = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>taxi edit</title>
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
        <div class="card bg-light text-dark" style="padding-left: 10%;">
            <div class="card-body">
                <div>
                    <h2><b>แก้ไขข้อมูลรถแท็กซี่</b>
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_taxi.php"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                <form action="update_taxi.php" method="post" enctype="multipart/form-data">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carID"><b>รหัสรถแท็กซี่</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carID" id="carID" value="<?php echo $row['carID']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carBrand"><b>ยี่ห้อ</b></label>
                            <select style="font-size: 14pt;" size="1" class="form-control" name="carBrand" id="carBrand">
                                <option selected disabled value="">-กรุณาเลือกยี่ห้อรถ-</option>
                                <?php while ($data = mysqli_fetch_assoc($brand)) { ?>
                                    <option value="<?php echo $data["eBrands"] ?>" <?php
                                                                                    if ($row['carBrand'] == $data['eBrands']) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>><?php echo $data["eBrands"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carGen"><b>รุ่น</b></label>
                            <select style="font-size: 14pt;" size="1" class="form-control" name="carGen" id="carGen">
                                <?php
                                $brand = $row['carBrand'];
                                $sql = "select * from tbgenerate where eBrands = '$brand'";
                                $result5 = mysqli_query($con, $sql);
                                while ($row5 = mysqli_fetch_assoc($result5)) {
                                ?>
                                    <option value="<?php echo $row5['generate']; ?>"><?php echo $row5['generate']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carNum"><b>เลขทะเบียน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carNum" id="carNum" value="<?php echo $row['carNum']; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carBody"><b>เลขตัวถัง</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carBody" id="carBody" value="<?php echo $row['carBody']; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carYN"><b>ปีจดทะเบียน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carYN" id="carYN" value="<?php echo $row['carYN']; ?>">
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carRent"><b>ราคา/วัน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carRent" id="carRent" placeholder="ราคา" value="<?php echo $row['carRent']; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carColor"><b>สี</b></label>
                            <select style="font-size: 14pt;" size="1" id="carColor" name="carColor" class="form-control">
                                <option selected disabled>-กรุณาเลือกสีรถ-</option>
                                <option value="แดง" <?php if ($row['carColor'] == "แดง") {
                                                        echo "selected='selected'";
                                                    } ?>>แดง</option>
                                <option value="เขียว" <?php if ($row['carColor'] == "เขียว") {
                                                            echo "selected='selected'";
                                                        } ?>>เขียว</option>
                                <option value="เหลือง" <?php if ($row['carColor'] == "เหลือง") {
                                                            echo "selected='selected'";
                                                        } ?>>เหลือง</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="carStatus"><b>สถานะ</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carStatus" id="carStatus" value="ว่าง" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="col-md-4">
                            <label style="font-size: 14pt;" for="name" class="control-label"><b>รูปรถแท็กซี่</b></label>
                            <img src="../images/taxi/<?php echo $row['carPic']; ?>" id="preview" class="img-fluid img-thumbnail" style="width: 240px;height: 240px"><br><br>
                            <input style="font-size: 14pt;" type="file" name="upload" accept="image/*" onchange="preview_image(event)" />
                        </div>
                    </div>
                    <br>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success">ตกลง</button>
                            <!-- <button type="reset" class="btn btn-outline-warning">ยกเลิก</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script type="text/javascript">
    $('#carBrand').change(function() {
        var brand = $(this).val();
        console.log(brand)

        $.ajax({
            type: "POST",
            url: "../managerData/ajax_db.php",
            data: {
                id: brand,
                function: 'carBrand'
            },
            success: function(data) {
                $('#carGen').html(data);
            }
        });
    });
</script>