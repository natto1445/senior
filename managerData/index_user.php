<?php
include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>user index</title>
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
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h2><b>ข้อมูลผู้ใช้งาน</b>
                        <a class="text-success" style="float: right; padding-left: 15px" href="../managerData/create_user.php"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href=""><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                <div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="15%" align="center" style="font-size: 16pt;">รหัสผู้ใช้งาน</th>
                                <th width="20%" align="center" style="font-size: 16pt;">ชื่อ - นามสกุล</th>
                                <th width="10%" align="center" style="font-size: 16pt;">ตำแหน่ง</th>
                                <th width="20%" align="center" style="font-size: 16pt;">E-mail</th>
                                <th width="10%" align="center" style="font-size: 16pt;">เบอร์โทร</th>
                                <th width="5%" align="center" style="font-size: 16pt;">เพศ</th>
                                <th width="5%" align="center" style="font-size: 16pt;">แก้ไข</th>
                                <th width="5%" align="center" style="font-size: 16pt;">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM tbuser ORDER BY id DESC";
                            $result = mysqli_query($con, $query);

                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td style="font-size: 14pt;"><?php echo $row['usrID']; ?></td>
                                    <td style="font-size: 14pt;"><?php echo $row['usrName']; ?></td>
                                    <td style="font-size: 14pt;"><?php echo $row['level']; ?></td>
                                    <td style="font-size: 14pt;"><?php echo $row['email']; ?></td>
                                    <td style="font-size: 14pt;"><?php echo $row['numPhone']; ?></td>
                                    <td style="font-size: 14pt;" align="center"><?php echo $row['gender']; ?></td>
                                    <td style="font-size: 1.5rem;" align="center"><a class="text-warning" href="../managerData/edit_user.php?id=<?php echo $row['usrID']; ?>" onclick="return confirm('คุณต้องการแก้ไขข้อมูล <?php echo $row['usrName']; ?>')"><i class="fa fa-wrench" aria-hidden="true"></i></a></td>
                                    <td style="font-size: 1.5rem;" align="center"><a class="text-danger" href="../managerData/delete_user.php?id=<?php echo $row['usrID']; ?>" onclick="return confirm('คุณต้องการลบข้อมูล <?php echo $row['usrName']; ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php
                            }
                            mysqli_close($con);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
include('../includes/scripts.php');
?>