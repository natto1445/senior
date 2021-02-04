<?php 
    include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>generate index</title> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
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
        <?php include '../login/menu.php';?>
    </div>
    <div style="width: 80%;" class="center_div">
        <br>
        <div class="card bg-light text-dark">
            <div class="card-body">
                <div>
                    <h2><b>ข้อมูลรุ่นรถ</b>
                        <a class="text-success" style="float: right; padding-left: 15px" href="../managerData/create_generate.php"><i class="fa fa-car" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/index_generate.php" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                    <?php  unset($_SESSION['status']); ?>
                <?php endif ?>
                <div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="font-size: 16pt;" width="20%" align="center">ชื่อยี่ห้อ</th>
                            <th style="font-size: 16pt;" width="20%" align="center">ชื่อรุ่น</th>
                            <th style="font-size: 16pt;" width="5%" align="center">ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT * FROM tbgenerate ORDER BY id DESC"; 
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_array($result)) { 
                    ?>
                        <tr>
                            <td style="font-size: 14pt;" width="20%"><?php echo $row['eBrands'];?></td>
                            <td style="font-size: 14pt;" width="20%"><?php echo $row['generate'];?></td>
                            <td style="font-size: 1.5rem;" width="5%"><a class="text-danger" href="../managerData/delete_generate.php?id=<?php echo $row['generate'];?>" onclick="return confirm('คุณต้องการลบข้อมูลรุ่นรถ <?php echo $row['generate']; ?> ?')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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