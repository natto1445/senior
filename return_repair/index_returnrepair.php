<?php 
    include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>return repair</title> 
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
                    <h2><b>รับรถคืนจากการซ่อม</b>
                        <a class="text-warning" style="float: right; padding-left: 15px" href="../repaircar/create_repair.php"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                        <a class="text-secondary" style="float: right;" href="../return_repair/index_returnrepair.php" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                        $query = "SELECT * FROM tbrepair JOIN tbtaxi ON tbrepair.carID=tbtaxi.carID WHERE repair_status='กำลังซ่อม' ORDER BY tbrepair.id DESC"; 
                        $result = mysqli_query($con, $query);
                        
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="card" style="width: 60%;">
                            <div class="card-body" >
                            <table class="table-borderless">
                                <tbody>
                                <tr>
                                    <td rowspan="3" style="width: 240px;"><img src="../images/taxi/<?php echo $row['carPic'];?>" alt="taxi" width="100%"></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>เลขที่ซ่อม</b> : <?php echo $row['repID'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ยี่ห้อ</b> : <?php echo $row['carBrand'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>รุ่น</b> : <?php echo $row['carGen'];?></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; font-size: 14pt; padding-top: 10px"><b>ทะเบียน</b> : <?php echo $row['carNum'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt; padding-top: 10px"><b>วันที่ซ่อม</b> : <?php echo $row['dateRepair'];?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>รายการซ่อม</b> : <?php echo $row['text_rePair'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"><b>ราคาซ่อม</b> : <?php echo $row['price_rePair'];?></td>
                                    <td style="padding-left: 20px; font-size: 14pt;"> <a style="width: 150px;" class="btn btn-success" href="../return_repair/create_returnrepair.php?id=<?php echo $row['repID'];?>" onclick="return confirm('คุณต้องการรับรถ <?php echo $row['carID']; ?> จากการซ่อมใช่หรือไม่ ?')"><i style="font-size: 1.5rem;" class="fa fa-wrench" aria-hidden="true"></i> รับคืนจากซ่อม </a> </td>
                                    <td></td>
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