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
                    <h4><b>ข้อมูลบริษัท</b></h4>
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
                                            <td rowspan="5" style="width: 50%;"><img src="../images/company/<?php echo $row['comLogo']; ?>" class="img-thumbnail" alt="customer" width="100%"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 20px;"><b>รหัสบริษัท :</b> <?php echo $row['comID']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 20px;"><b>ชื่อบริษัท :</b> <?php echo $row['comName']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 20px;"><b>ที่อยู่บริษัท :</b> <?php echo $row['comAdd']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div align="left" style="padding-top: 10px; padding-left: 105px;">
                            <a style="width: 60px;" class="btn btn-warning" href="../managerData/edit_company.php?id=<?php echo $row['comID']; ?>" onclick="return confirm('คุณต้องการแกไขข้อมูล <?php echo $row['comName']; ?> ?')"><i class="fa fa-wrench" aria-hidden="true"></i></a>
                            <a style="width: 60px;" class="btn btn-danger" href="../home.php"><i class="fa fa-times" aria-hidden="true"></i></a>
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