<?php
include('../condb/condb.php');

$comID = $_REQUEST["id"];
$strSQL = "SELECT * FROM tbcompany WHERE comID='$comID' ";
$result = mysqli_query($con, $strSQL);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>company edit</title>
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
                    <h4><b>แก้ไขข้อมูลบริษัท</b>
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_company.php"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                <form action="update_company.php" method="post" enctype="multipart/form-data">
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="comID"><b>รหัสบริษัท</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="comID" id="comID" value="<?php echo $row['comID']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="comName"><b>ชื่อบริษัท</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="comName" id="comName" value="<?php echo $row['comName']; ?>">
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="comOwner"><b>ชื่อเจ้าของบริษัท</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="comOwner" id="comOwner" value="<?php echo $row['comOwner']; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="comAdd"><b>ที่อยู่บริษัท</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="comAdd" id="comAdd" value="<?php echo $row['comAdd']; ?>">
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="col-md-2">
                            <label style="font-size: 14pt;" for="name" class="control-label"><b>รูปบริษัท</b></label>
                            <img src="../images/company/<?php echo $row['comLogo']; ?>" id="preview" class="img-fluid img-thumbnail" style="width: 240px;height: 240px"><br><br>
                            <input style="font-size: 14pt;" type="file" name="upload" accept="image/*" onchange="preview_image(event)" />
                        </div>
                    </div>
                    <br>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>