<?php
include('../condb/condb.php');
//Load Establishment list from database

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>taxi create</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
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
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h2><b>เพิ่มข้อมูลผู้เช่า</b>
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_customer.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/create_customer.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                <form action="save_customer.php" method="post" enctype="multipart/form-data">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="cusCard"><b>เลขที่บัตรประชาชน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="cusCard" id="cusCard" placeholder="เลขที่บัตรประชาชน" maxlength="13">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="cusName"><b>ชื่อ นามสกุล</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="cusName" id="cusName" placeholder="ชื่อ นามสกุล">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="cusDriver"><b>เลขที่ใบขับขี่</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="cusDriver" id="cusDriver" placeholder="เลขที่ใบขับขี่" maxlength="8">
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="cusAdd"><b>ที่อยู่</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="cusAdd" id="cusAdd" placeholder="ที่อยู่">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="cusTel"><b>เบอร์โทร</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="cusTel" id="cusTel" placeholder="เบอร์โทร" maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="cusStatus"><b>สถานะ</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="cusStatus" id="cusStatus" value="ยังไม่เช่า" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-6">
                        <div class="col-md-4">
                            <label style="font-size: 14pt;" for="name" class="control-label"><b>รูปผู้เช่า</b></label>
                            <img id="preview" class="img-fluid img-thumbnail" style="width: 240px;height: 240px"><br><br>
                            <input style="font-size: 14pt;" type="file" name="upload" accept="image/*" onchange="preview_image(event)" />
                        </div>
                    </div>
                    <br>
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