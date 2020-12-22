<?php session_start(); 
include('../condb/condb.php');

  $ID = $_SESSION['id'];
  $name = $_SESSION['usrID'];
  $level = $_SESSION['level'];
  $usrName = $_SESSION['usrName'];

 	if($level == "admin" || $level == "employee" ){
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>menu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
  <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #CC99FF;">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <!-- Brand -->
        <a class="navbar-brand" href="../home.php">
          <img src="https://www.thaitaxiservices.com/wp-content/uploads/2017/08/favicon-1.png" alt="logo" style="width:40px;">
        </a>
        <ul class="navbar-nav mr-auto">
            <?php
              if($level == "admin"){
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop" data-toggle="dropdown">
                  ข้อมูลพื้นฐาน
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="../managerData/index_user.php">ข้อมูลผู้ใช้งาน</a>
                  <a class="dropdown-item" href="#">ข้อมูลบริษัท</a>
                  <a class="dropdown-item" href="../managerData/index_brand.php">ข้อมูลยี่ห้อรถ</a>
                  <a class="dropdown-item" href="#">ข้อมูลรุ่นรถ</a>
                  <a class="dropdown-item" href="#">ข้อมูลรถแท็กซี่</a>
                  <a class="dropdown-item" href="#">ข้อมูลผู้เช่า</a>
                </div>
              </li>
            <?php
              }
            ?>

            <?php
            if($level == "employee"){
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop" data-toggle="dropdown">
                ข้อมูลพื้นฐาน
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="../managerData/index_brand.php">ข้อมูลยี่ห้อรถ</a>
                <a class="dropdown-item" href="#">ข้อมูลรุ่นรถ</a>
                <a class="dropdown-item" href="#">ข้อมูลรถแท็กซี่</a>
                <a class="dropdown-item" href="#">ข้อมูลผู้เช่า</a>
              </div>
            </li>
            <?php
              }
            ?>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">สัญญาเช่า</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">ส่งมอบรถ</a>
            </li>
            <li class="nav-item"> 
                <a class="nav-link text-dark" href="#">รับรถคืน</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">ชำระเงิน</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">ส่งซ่อมรถ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="#">รับคืนจากซ่อม</a>
            </li>

            <!-- Dropdown -->
            <?php
            if($level == "admin"){
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" id="navbardrop" data-toggle="dropdown">
                รายงาน
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#">รายงาน 1</a>
                <a class="dropdown-item" href="#">รายงาน 2</a>
                <a class="dropdown-item" href="#">รายงาน 3</a>
              </div>
            </li>
            <?php
              }
            ?>
        </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-dark" href=""><i class="fa fa-user-circle" aria-hidden="true"> <?php echo $usrName; ?> </i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="../login/logout.php"><i class="fa fa-lock" aria-hidden="true"> ออกจากระบบ </i></a>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>
<?php } ?>