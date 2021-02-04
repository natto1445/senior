<?php
include('../condb/condb.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>company index</title>
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
                    <h2><b>ข้อมูลบริษัท</b></h2>
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
                    <?php unset($_SESSION['status']); ?>
                <?php endif ?>
                <div align="center">
                    <?php
                    $query = "SELECT * FROM tbcompany";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="card" style="width: 80%;">
                            <div class="card-body">
                                <table class="table-borderless" cellpadding="20px">
                                    <tbody>
                                        <tr>
                                            <td rowspan="2" style="width: 20%;"><img src="../images/company/<?php echo $row['comLogo']; ?>" class="img-thumbnail" alt="customer" width="100%"></td>
                                            <td style="font-size: 18pt;"><b>รหัสบริษัท :</h4></b> <?php echo $row['comID']; ?></td>
                                            <td style="font-size: 18pt;"><b>ชื่อบริษัท :</h4></b> <?php echo $row['comName']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 18pt;"><b>ชื่อเจ้าของบริษัท :</b> <?php echo $row['comOwner']; ?></td>
                                            <td style="font-size: 18pt;"><b>ที่อยู่บริษัท :</b> <?php echo $row['comAdd']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div align="left" style="padding-top: 10px; padding-left: 10%;">
                            <a style="width: 80px;" class="btn btn-warning" href="../managerData/edit_company.php?id=<?php echo $row['comID']; ?>" onclick="return confirm('คุณต้องการแกไขข้อมูล <?php echo $row['comName']; ?> ?')"> <i class="fa fa-wrench" aria-hidden="true"></i> </a>
                        </div>
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