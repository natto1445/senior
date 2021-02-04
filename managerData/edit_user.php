<?php
include('../condb/condb.php');

$usrID = $_REQUEST["id"];
$strSQL = "SELECT * FROM tbuser WHERE usrID='$usrID' ";
$result = mysqli_query($con, $strSQL);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>user edit</title>
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
                    <h2><b>แก้ไขข้อมูลผู้ใช้งาน
                            <a class="text-danger" style="float: right; padding-left: 15px" href="../managerData/index_user.php"><i class="fa fa-times" aria-hidden="true"></i></a>
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
                <form action="update_user.php" method="post">
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-4">
                            <label style="font-size: 14pt;" for="usrID"><b>รหัสผู้ใช้งาน</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="usrID" id="usrID" value="<?php echo $row['usrID']; ?>" maxlength="13" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label style="font-size: 14pt;" for="usrName"><b>ชื่อ - นามสกุล</b></label>
                            <input style="font-size: 14pt;" type="text" class="form-control" name="usrName" id="usrName" value="<?php echo $row['usrName']; ?>">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <label style="font-size: 14pt;" for="email"><b>Email</b></label>
                            <input style="font-size: 14pt;" type="email" class="form-control" name="email" id="email" value="<?php echo $row['email']; ?>">
                        </div>
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-5">
                            <label style="font-size: 14pt;" for="level"><b>ตำแหน่ง</b></label>
                            <select size="1" style="font-size: 14pt;" id="level" name="level" class="form-control">
                                <option selected disabled>เลือกตำแหน่ง</option>
                                <option value="admin" <?php if ($row['level'] == "admin") {
                                                            echo "selected='selected'";
                                                        } ?>>แอดมิน</option>
                                <option value="employee" <?php if ($row['level'] == "employee") {
                                                                echo "selected='selected'";
                                                            } ?>>พนักงาน</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label style="font-size: 14pt;" for="gender"><b>เพศ</b></label>
                            <select size="1" style="font-size: 14pt;" id="gender" name="gender" class="form-control">
                                <option selected disabled>เลือกเพศ</option>
                                <option value="ชาย" <?php if ($row['gender'] == "ชาย") {
                                                        echo "selected='selected'";
                                                    } ?>>ชาย</option>
                                <option value="หญิง" <?php if ($row['gender'] == "หญิง") {
                                                            echo "selected='selected'";
                                                        } ?>>หญิง</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label style="font-size: 14pt;" for="numPhone"><b>เบอร์โทร</b></label>
                        <input style="font-size: 14pt;" type="text" class="form-control" name="numPhone" id="numPhone" value="<?php echo $row['numPhone']; ?>" maxlength="10">
                    </div>
                    <div class="form-row col-md-8">
                        <div class="form-group col-md-10">
                            <button style="font-size: 14pt;" type="submit" class="btn btn-outline-success">อัพเดท</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>