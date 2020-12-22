<?php 
    include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>brand index</title> 
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
                    <h4>ข้อมูลยี่ห้อรถ
                        <a class="text-success" style="float: right; padding-left: 15px" href="../managerData/create_brand.php"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/index_brand.php" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                            <th width="20%" align="center">ชื่อแบรนด์อังกฤษ</th>
                            <th width="20%" align="center">ชื่อแบรนด์อังกฤษ</th>
                            <th width="5%" align="center">แก้ไข</th>
                            <th width="5%" align="center">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tbbrands "; 
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_array($result)) { 
                    ?>
                        <tr>
                            <td width="20%"><?php echo $row['eBrands'];?></td>
                            <td width="20%"><?php echo $row['tBrands'];?></td>
                            <td width="5%"><a class="text-warning" href="../managerData/edit_brand.php?id=<?php echo $row['eBrands'];?>" onclick="return confirm('คุณต้องการแก้ไขข้อมูล <?php echo $row['eBrands']; ?>')"><i class="fa fa-wrench" aria-hidden="true"></i></a></td>
                            <td width="5%"><a class="text-danger" href="../managerData/delete_brand.php?id=<?php echo $row['eBrands'];?>" onclick="return confirm('คุณต้องการลบข้อมูล <?php echo $row['eBrands']; ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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