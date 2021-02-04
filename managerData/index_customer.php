<?php 
    include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>customer index</title>
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
                    <h2><b>ข้อมูลผู้เช่า</b>
                        <a class="text-success" style="float: right; padding-left: 15px" href="../managerData/create_customer.php"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../managerData/index_customer.php" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                        $query = "SELECT * FROM tbcustomer ORDER BY id DESC"; 
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="card" style="width: 80%;">
                            <div class="card-body" >
                            <table class="table-borderless">
                                <tbody>
                                <tr>
                                    <td rowspan="3" style="width: 20%;"><img src="../images/customer/<?php echo $row['cusPic'];?>" class="img-thumbnail" alt="customer" width="100%"></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>เลขที่บัตรประชาชน :</b> <?php echo $row['cusCard'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ชื่อผู้เช่า :</b> <?php echo $row['cusName'];?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="padding-left: 20px; padding-top: 15px; font-size: 14pt;"><b>เลขใบขับขี่ :</b> <?php echo $row['cusDriver'];?></td>
                                    <td style="padding-left: 20px; padding-top: 15px; font-size: 14pt;"><b>ที่อยู่ :</b> <?php echo $row['cusAdd'];?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>เบอร์โทร :</b> <?php echo $row['cusTel'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>สถานะ :</b> <?php echo $row['cusStatus'];?></td>
                                    <td style="padding-left: 20px;"> <a style="width: 70px;" class="btn btn-warning" href="../managerData/edit_customer.php?id=<?php echo $row['cusCard'];?>" onclick="return confirm('คุณต้องการแกไขข้อมูล <?php echo $row['cusName']; ?> ?')"><i style="font-size: 1.5rem;" class="fa fa-wrench" aria-hidden="true"></i></a> </td>
                                    <td style="padding-left: 20px;"> <a style="width: 70px;" class="btn btn-danger" href="../managerData/delete_customer.php?id=<?php echo $row['cusCard'];?>" onclick="return confirm('คุณต้องการลบข้อมูล <?php echo $row['cusName']; ?> ?')"><i style="font-size: 1.5rem;" class="fa fa-trash" aria-hidden="true"></i></a> </td>
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