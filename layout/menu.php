<?php session_start();
include('../condb/condb.php');

$sql2 = "SELECT * FROM tbcompany";
$query2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($query2);

$level = $_SESSION['level'];
$name = $_SESSION['usrID'];

if(in_array($_SESSION['level'], ['admin','employee'])) {
?>

<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #333399;">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <!-- Brand -->
        <a class="navbar-brand" href="../home.php">
            <img src="../images/company/<?php echo $row2['comLogo']; ?>" alt="logo" style="width:60px;">
        </a>
        <ul class="navbar-nav mr-auto">
            <?php
            if ($level == "admin") {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light" href="#" id="navbardrop" data-toggle="dropdown">
                    ข้อมูลพื้นฐาน
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="../managerData/index_user.php">ข้อมูลผู้ใช้งาน</a>
                    <a class="dropdown-item" href="../managerData/index_company.php">ข้อมูลบริษัท</a>
                    <a class="dropdown-item" href="../managerData/index_brand.php">ข้อมูลยี่ห้อรถ</a>
                    <a class="dropdown-item" href="../managerData/index_generate.php">ข้อมูลรุ่นรถ</a>
                    <a class="dropdown-item" href="../managerData/index_taxi.php">ข้อมูลรถแท็กซี่</a>
                    <a class="dropdown-item" href="../managerData/index_customer.php">ข้อมูลผู้เช่า</a>
                </div>
            </li>
            <?php
            }
            if ($level == "employee") {
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-light" href="#" id="navbardrop" data-toggle="dropdown">ข้อมูลพื้นฐาน</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="../managerData/index_brand.php">ข้อมูลยี่ห้อรถ</a>
                    <a class="dropdown-item" href="../managerData/index_generate.php">ข้อมูลรุ่นรถ</a>
                    <a class="dropdown-item" href="../managerData/index_taxi.php">ข้อมูลรถแท็กซี่</a>
                    <a class="dropdown-item" href="../managerData/index_customer.php">ข้อมูลผู้เช่า</a>
                </div>
            </li>
            <?php
            }
            ?>
            <li class="nav-item">
                <a class="nav-link text-light" href="../contract/index_contract.php">สัญญาเช่า</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="../deliver/create_deliver.php">ส่งมอบรถ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="../return/create_return.php">รับรถคืน</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="../payment/index_payment.php">ชำระเงิน</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="../repaircar/create_repair.php">ส่งซ่อมรถ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="../return_repair/index_returnrepair.php">รับคืนจากซ่อม</a>
            </li>

            <!-- Dropdown -->
            <?php
            if ($level == "admin") {
            ?>
            <li class="nav-item">
                <a class="nav-link text-light" href="../report/index_report.php">รายงาน</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-light" href=""><i class="fa fa-user-circle" aria-hidden="true"> <?php echo @$_SESSION['usrName']; ?> </i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="../login/logout.php"><i class="fa fa-lock" aria-hidden="true"> ออกจากระบบ </i></a>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>