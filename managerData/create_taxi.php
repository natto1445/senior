<?php
    include('../condb/condb.php');
    //Load Establishment list from database
    $sql = "SELECT * from tbbrands";
    $brand = mysqli_query($con, $sql);

    $sql = "SELECT * from tbgenerate";
    $gen = mysqli_query($con, $sql);

    $sql = "SELECT MAX(id) as maxid from tbtaxi ";
    $taxi = mysqli_query($con, $sql);
    $data = mysqli_fetch_array($taxi);

    $date = date('Y');

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
        function preview_image(event){
            var reader = new FileReader();
            reader.onload = function()
            {
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
                    <h4>เพิ่มข้อมูลรถแท็กซี่
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_taxi.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/create_taxi.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                <form action="save_taxi.php" method="post" enctype="multipart/form-data">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label for="carID">รหัสรถแท็กซี่</label>
                            <input type="text" class="form-control" name="carID" id="carID" value="TX-<?php echo $date ?>-00<?php echo $data['maxid']+1 ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carBrand">ยี่ห้อ</label>
                            <select class="form-control" name="carBrand" id="carBrand">
                                    <option selected disabled value="">-กรุณาเลือกยี่ห้อรถ-</option>
                                <?php while ($data = mysqli_fetch_assoc($brand)) { ?>
                                    <option value="<?php echo $data["eBrands"] ?>"><?php echo $data["eBrands"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carGen">รุ่น</label>
                            <select class="form-control" name="carGen" id="carGen">
                            </select>
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label for="carNum">เลขทะเบียน</label>
                            <input type="text" class="form-control" name="carNum" id="carNum" placeholder="เลขทะเบียน">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carBody">เลขตัวถัง</label>
                            <input type="text" class="form-control" name="carBody" id="carBody" placeholder="เลขตัวถัง">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carYN">ปีจดทะเบียน</label>
                            <input type="text" class="form-control" name="carYN" id="carYN" placeholder="ปีจดทะเบียน">
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label for="carRent">ราคา/วัน</label>
                            <input type="text" class="form-control" name="carRent" id="carRent" placeholder="ราคา">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carColor">สี</label>
                            <select id="carColor" name="carColor" class="form-control">
                                <option selected disabled>-กรุณาเลือกสีรถ-</option>
                                <option value="แดง">แดง</option>
                                <option value="เขียว">เขียว</option>
                                <option value="เหลือง">เหลือง</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="carStatus">สถานะ</label>
                            <input type="text" class="form-control" name="carStatus" id="carStatus" value="ว่าง" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-10">
                        <div class="col-md-4">
                            <label for="name" class="control-label">รูปรถแท็กซี่</label>
                            <img id="preview" class="img-fluid img-thumbnail" style="width: 240px;height: 240px" ><br><br>
                            <input type="file" name="upload" accept="image/*" onchange="preview_image(event)"/>
                        </div>
                    </div>
                    <br>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button type="submit" class="btn btn-outline-success">ตกลง</button>
                            <button type="reset" class="btn btn-outline-warning">ยกเลิก</button>
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
      data: {id:brand,function:'carBrand'},
      success: function(data){
          $('#carGen').html(data);
      }
    });
  });
</script>