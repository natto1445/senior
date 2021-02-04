<?php
include('../condb/condb.php');

//Load Establishment list from database
$sql = "SELECT * from tbcustomer where cusStatus='ยังไม่เช่า'";
$cus = mysqli_query($con, $sql);

$sql = "SELECT MAX(id) as maxid from tbcontract ";
$contract = mysqli_query($con, $sql);
$data = mysqli_fetch_array($contract);

$date = date('Y');
$datenow = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>contract create</title>
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


    <div style="width: 80%;" class="center_div">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h2><b>ค้นหารถแท็กซี่</b>
                        <a class="text-secondary" style="float: right; padding-right: 15px" href="../contract/create_contract.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h2>
                </div>

                <!-- แจ้งเตือนข้อมูลรถแท็กซี่ -->
                <?php if (isset($_SESSION['no_data'])) : ?>
                    <script>
                        swal({
                            title: "<?php echo $_SESSION['no_data']; ?>",
                            icon: "info",
                            button: "OK",
                        });
                    </script>
                    <?php unset($_SESSION['no_data']); ?>
                <?php endif ?>

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
                <form action="find_taxi.php" method="post">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="hirStart_find"><b>วันที่เริ่มเช่า</b></label>
                            <input style="font-size: 14pt;" type="date" class="form-control" name="hirStart_find" id="hirStart_find">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="hirEnd_find"><b>วันที่สิ้นสุด</b></label>
                            <input style="font-size: 14pt;" type="date" class="form-control" name="hirEnd_find" id="hirEnd_find">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="hirPattern_find"><b>รูปแบบการเช่า</b></label>
                            <select style="font-size: 14pt;" size="1" id="hirPattern_find" name="hirPattern_find" class="form-control">
                                <option selected disabled>-กรุณาเลือกรูปแบบ-</option>
                                <option value="แบบเต็มวัน">แบบเต็มวัน</option>
                                <option value="แบบกะเช้า">แบบกะเช้า</option>
                                <option value="แบบกะดึก">แบบกะดึก</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="button" name="submit_find" id="submit_find" class="btn btn-outline-success">ตกลง</button>
                            <button style="font-size: 14pt;" type="reset" class="btn btn-outline-warning">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- check select pattern -->
        <script>
            $(document).ready(function() {
                $('#submit_find').on('click', function() {
                    var hirStart_text = $('#hirStart_find').val();
                    var hirEnd_text = $('#hirEnd_find').val();
                    var pattern_text = $('#hirPattern_find option:selected').text();
                    if (hirStart_text == "" || hirEnd_text == "" || pattern_text == "-กรุณาเลือกรูปแบบ-") {
                        swal({
                            title: "กรุณาป้อนข้อมูลค้นหาให้ครบถ้วน",
                            icon: "info",
                            button: "OK",
                        });
                    } else {
                        $('button[name="submit_find"]').prop("type", "submit");
                    }
                });
            });
        </script>

        <br>
        <!-- โหลดข้อมูลรถแท็กซี่ที่ว่าง -->
        <?php if (isset($_SESSION["data_found"])) :
            $carID = $_SESSION["carID"];
            $sql = "SELECT * FROM tbtaxi WHERE carID NOT IN('$carID') AND carStatus='ว่าง'";
            $query = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($query)) {
        ?>

                <div class="center_div" style="width: 60%;">
                    <div class="card-body">
                        <table class="table-borderless">
                            <tbody>
                                <tr>
                                    <td rowspan="3" style="width: 240px;"><img src="../images/taxi/<?php echo $row['carPic']; ?>" class="img-thumbnail" alt="taxi" width="100%"></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ยี่ห้อ :</b> <?php echo $row['carBrand']; ?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>รุ่น :</b> <?php echo $row['carGen']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; font-size: 14pt; padding-top: 15px;"><b>รหัสรถ :</b> <?php echo $row['carID']; ?> <input value="<?php echo $row['carID']; ?>" type="hidden" name="carID" id="carID" readonly></td>
                                    <td style="padding-left: 20px; font-size: 14pt; padding-top: 15px;"><b>ทะเบียน :</b> <?php echo $row['carNum']; ?> <input value="<?php echo $row['carNum']; ?>" type="hidden" name="carNum" id="carNum" readonly></td>
                                    <td style="padding-left: 20px; font-size: 14pt; padding-top: 15px;"><b>ปีจดทะเบียน :</b> <?php echo $row['carYN']; ?></td>
                                </tr>
                                <tr>

                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ราคา :</b> <?php echo $row['carRent']; ?> <input value="<?php echo $row['carRent']; ?>" type="hidden" name="carRent" id="carRent" readonly></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>สถานะ :</b> <?php echo $row['carStatus']; ?></td>
                                    <td style="padding-left: 20px;">
                                        <button font-size: 14pt; type="submit" id="car_select" class="btn btn-success">เลือก</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <?php unset($_SESSION["data_found"]) ?>
        <?php }
        endif ?>

        <!-- script เลือกรถ -->
        <script>
            $(document).ready(function() {
                $("body").on("click", "#car_select", function() {
                    let carRent = $(this).closest("tbody").find("#carRent").val();
                    let carNum = $(this).closest("tbody").find("#carNum").val();
                    let carID = $(this).closest("tbody").find("#carID").val();
                    <?php if ($_SESSION["pattern"] == "แบบเต็มวัน") { ?>
                        $('#hirStart').val(
                            '<?php echo $_SESSION["hirStart"] ?>'
                        );
                        $('#hirEnd').val(
                            '<?php echo $_SESSION["hirEnd"] ?>'
                        );
                        $('#numDay').val(
                            '<?php echo $_SESSION["numDay"] ?>'
                        );
                        $('#hirPattern').val(
                            '<?php echo $_SESSION["pattern"] ?>'
                        );
                        $('#hirDeposit').val(
                            (carRent * <?php echo $_SESSION["numDay"] ?>) / 2
                        );
                        $('#hirCarID').val(carID);
                        $('#hircarNum').val(carNum);
                        $('#hirCarRent').val(carRent);
                        $('#timeStart').val('09:00:00');
                        $('#timeEnd').val('09:00:00');
                    <?php
                    } else if ($_SESSION["pattern"] == "แบบกะดึก") { ?>
                        $('#hirStart').val(
                            '<?php echo $_SESSION["hirStart"] ?>'
                        );
                        $('#hirEnd').val(
                            '<?php echo $_SESSION["hirEnd"] ?>'
                        );
                        $('#numDay').val(
                            '<?php echo $_SESSION["numDay"] ?>'
                        );
                        $('#hirPattern').val(
                            '<?php echo $_SESSION["pattern"] ?>'
                        );
                        $('#hirDeposit').val(
                            (carRent / 2) * (<?php echo $_SESSION["numDay"] ?>) / 2
                        );
                        $('#hirCarID').val(carID);
                        $('#hircarNum').val(carNum);
                        $('#hirCarRent').val(carRent / 2);
                        $('#timeStart').val('16:00:00');
                        $('#timeEnd').val('04:00:00');
                    <?php } else if ($_SESSION["pattern"] == "แบบกะเช้า") { ?>
                        $('#hirStart').val(
                            '<?php echo $_SESSION["hirStart"] ?>'
                        );
                        $('#hirEnd').val(
                            '<?php echo $_SESSION["hirEnd"] ?>'
                        );
                        $('#numDay').val(
                            '<?php echo $_SESSION["numDay"] ?>'
                        );
                        $('#hirPattern').val(
                            '<?php echo $_SESSION["pattern"] ?>'
                        );
                        $('#hirDeposit').val(
                            (carRent / 2) * (<?php echo $_SESSION["numDay"] ?>) / 2
                        );
                        $('#hirCarID').val(carID);
                        $('#hircarNum').val(carNum);
                        $('#hirCarRent').val(carRent / 2);
                        $('#timeStart').val('04:00:00');
                        $('#timeEnd').val('16:00:00');
                    <?php } ?>


                    //console.log(row)
                })
            });
        </script>

        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h2><b>ทำสัญญาเช่า</b></h2>
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
                <form action="save_contract.php" method="post">
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirNum"><b>เลขที่สัญญา</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirNum" id="hirNum" value="CT-<?php echo $date ?>-00<?php echo $data['maxid'] + 1 ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirDate"><b>วันที่ทำสัญญา</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirDate" id="hirDate" value="<?php echo $datenow ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirStart"><b>วันที่เริ่มเช่า</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirStart" id="hirStart" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirEnd"><b>วันที่สิ้นสุด</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirEnd" id="hirEnd" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirPattern"><b>รูปแบบการเช่า</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirPattern" id="hirPattern" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="timeStart"><b>เวลาเริ่มเช่า</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="timeStart" id="timeStart" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="timeEnd"><b>เวลาสิ้นสุด</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="timeEnd" id="timeEnd" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="usrID"><b>ชื่อพนักงาน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrName"] ?>" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="cusCard"><b>ชื่อผู้เช่า</b></label>
                            <select style="font-size: 14pt;" size="1" class="form-control" name="cusCard" id="cusCard">
                                <option selected disabled value="">-กรุณาเลือกผู้เช่า-</option>
                                <?php while ($data = mysqli_fetch_assoc($cus)) { ?>
                                    <option value="<?php echo $data["cusCard"] ?>"><?php echo $data["cusName"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="carID"><b>หมายเลขทะเบียนรถ</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carNum" id="hircarNum" readonly>
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="numDay"><b>จำนวนวันที่เช่า</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="numDay" id="numDay" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="carRent"><b>ราคารถแท็กซี่/วัน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="carRent" id="hirCarRent" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirDeposit"><b>ราคามัดจำ</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirDeposit" id="hirDeposit" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label style="font-size: 14pt;" for="hirStatus"><b>สถานะ</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirStatus" id="hirStatus" value="จองรถ" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <input style="font-size: 14pt;" type="text" class="form-control" name="hirCarID" id="hirCarID" hidden>
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="button" id="save_contract" name="save_contract" class="btn btn-outline-success">ตกลง</button>
                            <button style="font-size: 14pt;" type="reset" class="btn btn-outline-warning">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <!-- check ชื่อผู้เช่า -->
    <script>
        $(document).ready(function() {
            $('#save_contract').on('click', function() {
                var cusName = $('#cusCard option:selected').text();
                let carNum = $("#hircarNum").val();
                if (cusName == "-กรุณาเลือกผู้เช่า-") {
                    swal({
                        title: "กรุณาเลือกข้อมูลผู้เช่า",
                        icon: "info",
                        button: "OK",
                    });
                } else if (carNum == "") {
                    swal({
                        title: "ยังไม่ได้เลือกรถแท็กซี่",
                        icon: "info",
                        button: "OK",
                    });
                } else {
                    $('button[name="save_contract"]').prop("type", "submit");
                }
            });
        });
    </script>
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

    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("hirStart_find")[0].setAttribute('min', today);

    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("hirEnd_find")[0].setAttribute('min', today);
</script>