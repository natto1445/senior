<?php
include('../condb/condb.php');

//Load Establishment list from database
$sql = "SELECT * FROM tbcontract JOIN tbtaxi ON tbcontract.carID=tbtaxi.carID WHERE hirStatus='จองรถ' AND deliver='1'";
$contract = mysqli_query($con, $sql);

$query = "SELECT MAX(id) as maxid from tbreturn";
$contract2 = mysqli_query($con, $query);
$data = mysqli_fetch_array($contract2);
$result = $data['maxid'];

$date = date('Y');

$datenow = date('Y-m-d');
date_default_timezone_set("Asia/Bangkok");
$time = date('H:i:s');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>return create</title>
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

    <div style="width: 80%;" class="center_div">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h2><b>รับรถคืนจากการเช่า</b>
                        <a class="text-secondary" style="float: right; padding-left: 15px" href="../payment/index_payment.php"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right" href="../return/create_return.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h2>
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
                        <div class="form-group col-md-2">
                            <label style="font-size: 14pt;" for="hirNum_find"><b>ทะเบียนรถ</b></label>
                            <select style="font-size: 14pt;" size="1" class="form-control" name="hirNum_find" id="hirNum_find">
                                <option selected disabled value="">-กรุณาเลือกทะเบียน-</option>
                                <?php while ($data = mysqli_fetch_assoc($contract)) { ?>
                                    <option value="<?php echo $data["hirNum"] ?>"><?php echo $data["carNum"] ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrName"] ?>" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label style="font-size: 14pt;" for="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <button style="font-size: 14pt;" type="button" name="submit_find" id="submit_find" class="btn btn-outline-success">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <!-- โหลดข้อมูลรถแท็กซี่ที่ว่าง -->
        <?php if (isset($_SESSION["data_true"])) :
            $data = $_SESSION["data"];
            $sql = "SELECT * FROM tbcontract JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbcontract.usrID = tbuser.usrID  WHERE hirNum = '$data'";
            $query = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($query)) {
        ?>

                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <form action="save_return.php" method="post">
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="hirNum"><b>สัญญาเช่า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="hirNum" id="hirNum" value="<?php echo $row['hirNum']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="cusName"><b>ชื่อผู้เช่า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="cusName" id="cusName" value="<?php echo $row['cusName']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="cusCard" id="cusCard" value="<?php echo $row['cusCard']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="usrName"><b>พนักงานให้เช่า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="usrName" id="usrName" value="<?php echo $row['usrName']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrID"] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="carNum"><b>ทะเบียนรถ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="carNum" id="carNum" value="<?php echo $row['carNum']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="carID" id="carID" value="<?php echo $row['carID']; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row col-md-12">
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="retID"><b>เลขที่รับคืน</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="retID" id="retID" value="RE-<?php echo $date ?>-00<?php echo $result + 1 ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="hirStart"><b>วันที่เริ่มเช่า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="hirStart" id="hirStart" value="<?php echo $row['hirStart']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="hirEnd"><b>วันที่สิ้นสุด</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="hirEnd" id="hirEnd" value="<?php echo $row['hirEnd']; ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="usrID" id="usrID" value="<?php echo $_SESSION["usrID"] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="numDay"><b>จำนวนวัน</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="numDay" id="numDay" value="<?php echo $row['numDay']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="carRent"><b>ราคารถ/วัน</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="carRent" id="carRent" value="<?php echo $row['carRent']; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-row col-md-12">
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="datenow"><b>วันที่เอามาคืน</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="datenow" id="datenow" value="<?php echo $datenow ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="timeEnd"><b>เวลาที่ต้องคืน</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="timeEnd" id="timeEnd" value="<?php echo $row['timeEnd']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="time"><b>เวลาเอามาคืน</b></label>
                                    <input style="font-size: 14pt;" type="time" class="form-control" name="time" id="time" value="<?php echo $time ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="numRate"><b>วันคืนช้า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="numRate" id="numRate" value="" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="timeRate"><b>เวลาคืนช้า</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="timeRate" id="timeRate" value="" readonly>
                                </div>
                            </div>

                            <div class="form-row col-md-12">
                                <div class="form-group col-md-3">
                                    <label style="font-size: 14pt;" for="hirTotal"><b>ราคาเช่าทั้งหมด</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="hirTotal1" id="hirTotal1" value="<?php echo number_format($row['hirDeposit'] * 2); ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="hirTotal" id="hirTotal" value="<?php echo ($row['hirDeposit'] * 2); ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="hirDeposit"><b>จำนวนมัดจำ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="hirDeposit1" id="hirDeposit1" value="<?php echo number_format($row['hirDeposit']); ?>" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="hirDeposit" id="hirDeposit" value="<?php echo $row['hirDeposit']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="balance"><b>ยอดคงเหลือ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="balance1" id="balance1" value="" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="balance" id="balance" value="" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="Fines"><b>ค่าปรับ **1000/วัน**</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="Fines1" id="Fines1" value="" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="Fines" id="Fines" value="" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label style="font-size: 14pt;" for="total"><b>สุทธิ</b></label>
                                    <input style="font-size: 14pt;" type="text" class="form-control" name="total1" id="total1" value="" readonly>
                                    <input style="font-size: 14pt;" type="hidden" class="form-control" name="total" id="total" value="" readonly>
                                </div>
                            </div>
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-5">
                                    <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success">รับคืน</button>
                                    <a style="font-size: 14pt;" class="btn btn-outline-danger" href="../return/create_return.php">ยกเลิก</a>
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
                    var contract = $('#hirNum_find option:selected').text();
                    if (contract == "-กรุณาเลือกสัญญาเช่า-") {
                        swal({
                            title: "กรุณาเลือกสัญญาเช่า",
                            icon: "info",
                            button: "OK",
                        });
                    } else {
                        $('button[name="submit_find"]').prop("type", "submit");
                    }
                });

                var dateReturn = $('#hirEnd').val();
                var datenow = $('#datenow').val();
                console.log(dateReturn)
                console.log(datenow)

                var hirTotal = $('#hirTotal').val();
                var hirDeposit = $('#hirDeposit').val();
                let balance = hirTotal - hirDeposit
                let Fines = 0
                $("#balance").val(balance);
                $("#balance1").val(balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                if (datenow < dateReturn) {
                    let numday = 0
                    let timerate = "00:00"
                    Fines = 1000 * numday

                    $("#numRate").val(numday);
                    $("#timeRate").val(timerate);
                    $("#Fines").val(Fines);
                    $("#Fines1").val(Fines.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                } else if (datenow > dateReturn) {
                    console.log("มากกว่า")
                    const diffTime = Math.abs(new Date(datenow) - new Date(dateReturn))
                    let diffDay = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

                    let timerate = "00:00"
                    $("#numRate").val(diffDay);
                    $("#timeRate").val(timerate);
                    Fines = 1000 * diffDay
                    $("#Fines").val(Fines);
                    $("#Fines1").val(Fines.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                } else {
                    console.log("เท่ากัน")
                    let recar = $("#timeEnd").val()
                    let relate = $("#time").val()
                    console.log(recar)
                    console.log(relate)
                    if (relate < recar) {
                        let numday = 0
                        let timerate = "00:00"
                        Fines = 1000 * numday

                        $("#numRate").val(numday);
                        $("#timeRate").val(timerate);
                        $("#Fines").val(Fines);
                        $("#Fines1").val(Fines.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    } else {
                        start = recar.split(":");
                        end = relate.split(":");
                        var startDate = new Date(0, 0, 0, start[0], start[1], 0);
                        var endDate = new Date(0, 0, 0, end[0], end[1], 0);
                        var diff = endDate.getTime() - startDate.getTime();
                        var hours = Math.floor(diff / 1000 / 60 / 60);
                        diff -= hours * 1000 * 60 * 60;
                        var minutes = Math.floor(diff / 1000 / 60);

                        if (hours >= 1) {
                            diffDay = 1
                            $("#numRate").val(diffDay);
                            console.log(diffDay)
                            $("#timeRate").val(diffDay)
                            let price = diffDay * 1000;
                            $("#Fines").val(price)
                            console.log(hours + ":" + minutes)
                            $("#timeRate").val(hours + ":" + minutes)
                        }
                    }

                }
                let total = balance + Fines
                $("#total").val(total);
                $("#total1").val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            });
        </script>

</body>

</html>

<!-- <script type="text/javascript">
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("del_date")[0].setAttribute('min', today);
</script> -->