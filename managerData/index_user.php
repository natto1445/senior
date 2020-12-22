<?php 
    include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>user index</title> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="../js/sweetalert.min.js"></script>
</head>

<body style="background-image: url('images/bg.jpg');">
    <div class="menu">
        <?php include '../login/menu.php';?>
    </div>
    <div class="container">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h4>ข้อมูลผู้ใช้งาน
                        <a class="text-success" style="float: right; padding-left: 15px" href="../managerData/create_user.php"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="15%" align="center">รหัสผู้ใช้งาน</th>
                            <th width="20%" align="center">ชื่อ - นามสกุล</th>
                            <th width="10%" align="center">ตำแหน่ง</th>
                            <th width="20%" align="center">E-mail</th>
                            <th width="10%" align="center">เบอร์โทร</th>
                            <th width="5%" align="center">เพศ</th>
                            <th width="5%" align="center">แก้ไข</th>
                            <th width="5%" align="center">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tbuser "; 
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_array($result)) { 
                    ?>
                        <tr>
                            <td><?php echo $row['usrID'];?></td>
                            <td><?php echo $row['usrName'];?></td>
                            <td><?php echo $row['level'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['numPhone'];?></td>
                            <td align="center"><?php echo $row['gender'];?></td>
                            <td align="center"><a class="text-warning" href="../managerData/edit_user.php?id=<?php echo $row['usrID'];?>" onclick="return confirm('คุณต้องการแก้ไขข้อมูล <?php echo $row['usrName']; ?>')"><i class="fa fa-wrench" aria-hidden="true"></i></a></td>
                            <td align="center"><a class="text-danger" href="../managerData/delete_user.php?id=<?php echo $row['usrID'];?>" onclick="return confirm('คุณต้องการลบข้อมูล <?php echo $row['usrName']; ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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