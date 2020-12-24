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
                    <h4>เพิ่มข้อมูลผู้ใช้งาน
                        <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_user.php"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/create_user.php"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                <form action="save_user.php" method="post">
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-4">
                            <label for="usrID">รหัสผู้ใช้งาน</label>
                            <input type="text" class="form-control" name="usrID" id="usrID" placeholder="0000000000000" maxlength="13">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="usrName">ชื่อ - นามสกุล</label>
                            <input type="text" class="form-control" name="usrName" id="usrName" placeholder="ชื่อ - นามสกุล">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-5">
                            <label for="level">ตำแหน่ง</label>
                            <select id="level" name="level" class="form-control">
                                <option selected disabled>-กรุณาเลือกตำแหน่ง-</option>
                                <option value="admin">แอดมิน</option>
                                <option value="employee">พนักงาน</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="gender">เพศ</label>
                            <select id="gender" name="gender" class="form-control">
                                <option selected disabled>-กรุณาเลือกเพศ-</option>
                                <option value="ชาย">ชาย</option>
                                <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="numPhone">เบอร์โทร</label>
                        <input type="text" class="form-control" name="numPhone" id="numPhone" placeholder="เบอร์โทร" maxlength="10">
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-5">
                            <label for="pass">รหัสผ่าน</label>
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="กรอกรหัสผ่าน">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="pass2">ยืนยันรหัสผ่าน</label>
                            <input type="password" class="form-control" name="pass2" id="pass2" placeholder="กรอกรหัสผ่านอีกครั้ง">
                        </div>
                    </div>
                    <!-- <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                        <input type="file" id="myFile" name="filename">
                        </div>
                    </div> -->
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