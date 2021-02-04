<?php 
    include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>taxi index</title> 
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
                    <h2><b>ข้อมูลรถแท็กซี่</b>
                        <a class="text-success" style="float: right; padding-left: 15px" href="../managerData/create_taxi.php"><i class="fa fa-car" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/index_taxi.php" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
                    </h2>
                </div>
                <br>
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
                <div align="center">              
                    <?php
                        $query = "SELECT * FROM tbtaxi ORDER BY id DESC"; 
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="card" style="width: 60%;">
                            <div class="card-body" >
                            <table class="table-borderless">
                                <tbody>
                                <tr>
                                    <td rowspan="3" style="width: 240px;"><img src="../images/taxi/<?php echo $row['carPic'];?>" class="img-thumbnail" alt="taxi" width="100%"></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ยี่ห้อ :</b> <?php echo $row['carBrand'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>รุ่น :</b> <?php echo $row['carGen'];?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="padding-left: 20px; padding-top: 15px; font-size: 14pt;"><b>ทะเบียน :</b> <?php echo $row['carNum'];?></td>
                                    <td style="padding-left: 20px; padding-top: 15px; font-size: 14pt;"><b>ปีจดทะเบียน :</b> <?php echo $row['carYN'];?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ราคา :</b> <?php echo $row['carRent'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>สถานะ :</b> <?php echo $row['carStatus'];?></td>
                                    <td style="padding-left: 20px;"> <a style="width: 70px;" class="btn btn-warning" href="../managerData/edit_taxi.php?id=<?php echo $row['carID'];?>" onclick="return confirm('คุณต้องการแกไขข้อมูล <?php echo $row['carNum']; ?> ?')"><i style="font-size: 1.5rem;" class="fa fa-wrench" aria-hidden="true"></i></a> </td>
                                    <td style="padding-left: 20px;"> <a style="width: 70px;" class="btn btn-danger" href="../managerData/delete_taxi.php?id=<?php echo $row['carID'];?>" onclick="return confirm('คุณต้องการลบข้อมูล <?php echo $row['carNum']; ?> ?')"><i style="font-size: 1.5rem;" class="fa fa-trash" aria-hidden="true"></i></a> </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <br>
                    <?php  
                        }            
                            mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php 
    include('../includes/scripts.php');
?>