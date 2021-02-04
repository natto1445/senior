<!DOCTYPE html>
<html lang="en">

<head>
    <title>user create</title>
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
        <div class="card bg-light text-dark" style="padding-left: 10%;">
            <div class="card-body">
                <div>
                    <h2><b>เพิ่มข้อมูลผู้ใช้งาน
                            <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_user.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <a class="text-secondary" style="float: right;" href="../managerData/create_user.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                <form action="save_user.php" method="post">
                    <div class="form-row col-md-10">
                        <div class="form-group col-md-2">
                            <label style="font-size: 14pt;" for="usrID"><b>รหัสผู้ใช้งาน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="usrID" id="usrID" placeholder="0000000000000" maxlength="13">
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 14pt;" for="usrName"><b>ชื่อ - นามสกุล</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="usrName" id="usrName" placeholder="ชื่อ - นามสกุล">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-6">
                            <label style="font-size: 14pt;" for="email"><b>Email</b></label>
                            <input style="font-size: 14pt;" type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-5">
                            <label style="font-size: 14pt;" for="level"><b>ตำแหน่ง</b></label>
                            <select size="1" style="font-size: 14pt;" id="level" name="level" class="form-control">
                                <option selected disabled>-กรุณาเลือกตำแหน่ง-</option>
                                <option value="admin">แอดมิน</option>
                                <option value="employee">พนักงาน</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label style="font-size: 14pt;" for="gender"><b>เพศ</b></label>
                            <select size="1" style="font-size: 14pt;" id="gender" name="gender" class="form-control">
                                <option selected disabled>-กรุณาเลือกเพศ-</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label style="font-size: 14pt;" for="numPhone"><b>เบอร์โทร</b></label>
                        <input style="font-size: 14pt;" type="text" class="form-control" name="numPhone" id="numPhone" placeholder="เบอร์โทร" maxlength="10">
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-5">
                            <label style="font-size: 14pt;" for="pass"><b>รหัสผ่าน</b></label>
                            <input style="font-size: 14pt;" type="password" class="form-control" name="pass" id="pass" placeholder="กรอกรหัสผ่าน">
                        </div>
                        <div class="form-group col-md-5">
                            <label style="font-size: 14pt;" for="pass2"><b>ยืนยันรหัสผ่าน</b></label>
                            <input style="font-size: 14pt;" type="password" class="form-control" name="pass2" id="pass2" placeholder="กรอกรหัสผ่านอีกครั้ง">
                        </div>
                    </div>
                    <!-- <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                        <input type="file" id="myFile" name="filename">
                        </div>
                    </div> -->
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