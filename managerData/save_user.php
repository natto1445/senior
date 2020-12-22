<?php session_start();?>

<mate charset ="utf-8" />
<?php include ('../condb/condb.php');	
    //สร้างตัวแปร
    $usrID = $_POST['usrID'];
    $usrName = $_POST['usrName'];
    $level = $_POST['level'];
    $email = $_POST['email'];
    $numPhone = $_POST['numPhone'];
    $gender = $_POST['gender'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    
    $sql = "SELECT usrID FROM tbuser WHERE usrID='$usrID'";
    $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result)==1){
            $_SESSION['status'] = "มีรหัสผู้ใช้งานนี้แล้ว !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_user.php');
        }

    //เพิ่มข้อมูล
    if($usrID=="" || $usrName=="" || $level=="" || $email=="" || $numPhone=="" || $gender=="" || $pass=="" || $pass2==""){
            $_SESSION['status'] = "กรุณากรอกข้อมูล !";
            $_SESSION['status_code'] = "info";
            header('Location: ../managerData/create_user.php');
    }elseif($pass!=$pass2){
            $_SESSION['status'] = "รหัสผ่านไม่ตรงกัน !";
            $_SESSION['status_code'] = "warning";
            header('Location: ../managerData/create_user.php');
    }else{
        $sql = " INSERT INTO tbuser
        (usrID, usrName, level, email, numPhone, gender, password)
        VALUES
        ('$usrID', '$usrName', '$level', '$email', '$numPhone', '$gender', '$pass')";
        $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
        mysqli_close($con);

        //ถ้าสำเร็จให้ขึ้นอะไร
        if ($result){
            $_SESSION['status'] = "เพิ่มข้อมูลสำเร็จ !";
            $_SESSION['status_code'] = "success";
            header('Location: ../managerData/index_user.php');
            }
        else {
        //กำหนดเงื่อนไขว่าถ้าไม่สำเร็จให้ขึ้นข้อความและกลับไปหน้าเพิ่ม		
            $_SESSION['status'] = "เกิดข้อผิดพลาดในระบบ !";
            $_SESSION['status_code'] = "error";
            header('Location: ../managerData/create_user.php');
        }
    }
?>