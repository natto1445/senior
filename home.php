<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/sweetalert.min.js"></script>
</head>

<body style="background-image: url('images/bg.jpg');">
    <div class="menu">
        <?php include 'menu.php';?>
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

</body>
</html>