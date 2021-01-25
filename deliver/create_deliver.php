<?php
include('../condb/condb.php');

//Load Establishment list from database
$datenow = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>deliver create</title>
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

</head>

<body>
    <div class="menu">
        <?php include '../login/menu.php'; ?>
    </div>

    <!-- CHECK SAVE CONTRACT -->
    <?php if (isset($_SESSION["save_contract_msg"])) : ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['save_contract_msg']; ?>",
                icon: "<?php echo $_SESSION['save_contract_msg1']; ?>",
                button: "OK",
            });
        </script>
        <?php unset($_SESSION['save_contract_msg']); ?>
    <?php endif ?>


    <div class="container">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h4><b>ส่งมอบรถให้ผู้เช่า</b>
                        <a class="text-secondary" style="float: right; padding-right: 15px" href="../deliver/create_deliver.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h4>
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
                <form action="find_contract.php" method="post">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-3">
                            <label for="del_date">วันที่ส่งมอบ</label>
                            <input type="date" class="form-control" name="del_date" id="del_date">
                            <input type="hidden" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrName"] ?>" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="del_date">ค้นหา</label>
                            <button type="button" name="submit_find" id="submit_find" class="btn btn-outline-success">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <!-- โหลดข้อมูลรถแท็กซี่ที่ว่าง -->
        <?php if (isset($_SESSION["data_true"])) :
            $data = $_SESSION["data"];
            $sql = "SELECT tbcontract.hirNum,tbcontract.cusCard,tbcustomer.cusName,tbcustomer.cusPic,tbcontract.hirDate,tbcontract.hirStart,tbcontract.hirEnd,tbcontract.carID,tbtaxi.carNum,tbtaxi.carPic FROM tbcontract JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID  WHERE hirStart = '$data' AND hirStatus='จองรถ' AND tbcontract.deliver='0'";
            $query = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($query)) {
        ?>

                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <form action="save_deliver.php" method="post">
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-2">
                                    <img class="card-img-bottom img-thumbnail" src="../images/customer/<?php echo $row['cusPic']; ?>" alt="cusImg" style="height: 150px;">
                                </div>
                                <div class="form-group col-md-2">
                                    <img class="card-img-bottom img-thumbnail" src="../images/taxi/<?php echo $row['carPic']; ?>" alt="taxiImg" style="height: 150px;">
                                </div>
                                <div class="form-group col-md-3" style="padding-top: 30px;">
                                    <label for="delDate">วันที่ส่งมอบ</label>
                                    <input type="text" class="form-control" name="delDate" id="delDate" value="<?php echo $datenow ?>" readonly>
                                </div>
                                <div class="form-group col-md-3" style="padding-top: 30px;">
                                    <label for="hirNum">เลขที่สัญญา</label>
                                    <input type="text" class="form-control" name="hirNum" id="hirNum" value="<?php echo $row['hirNum']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                </div>
                            </div>
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="hirStart">วันที่เริ่มเช่า</label>
                                    <input type="text" class="form-control" name="hirStart" id="hirStart" value="<?php echo $row['hirStart']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="hirEnd">วันที่สิ้นสุด</label>
                                    <input type="text" class="form-control" name="hirEnd" id="hirEnd" value="<?php echo $row['hirEnd']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cusName">ชื่อลูกค้า</label>
                                    <input type="text" class="form-control" name="cusName" id="cusName" value="<?php echo $row['cusName']; ?>" readonly>
                                    <input type="hidden" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrID"] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="carNum">เลขทะเบียนรถ</label>
                                    <input type="text" class="form-control" name="carNum" id="carNum" value="<?php echo $row['carNum']; ?>" readonly>
                                    <input type="hidden" class="form-control" name="carID" id="carID" value="<?php echo $row['carID']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="button">ปล่อยรถ</label>
                                    <button type="submit" class="btn btn-outline-success">ตกลง</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php unset($_SESSION["data_true"]) ?>
        <?php }
        endif ?>

        <!-- check select pattern -->
        <script>
            $(document).ready(function() {
                $('#submit_find').on('click', function() {
                    var del_date = $('#del_date').val();
                    if (del_date == "") {
                        swal({
                            title: "ป้อนข้อมูลการค้นหาให้ครบถ้วน",
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

<script type="text/javascript">
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("del_date")[0].setAttribute('min', today);
</script>