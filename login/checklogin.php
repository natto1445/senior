<?php 
session_start();
        if(isset($_POST['usrID'])){
                  include('../condb/condb.php');
                  $username = $_POST['usrID'];
                  $password = $_POST['password'];

                  $sql="SELECT * FROM tbuser 
                  WHERE  usrID='".$username."' 
                  AND  password='".$password."' ";
                  $result = mysqli_query($con,$sql);
                  if(mysqli_num_rows($result)==1){
                      $row = mysqli_fetch_array($result);

                      $_SESSION["id"] = $row["id"];
                      $_SESSION["usrID"] = $row["usrID"];
                      $_SESSION["level"] = $row["level"];
                      $_SESSION["usrName"] = $row["usrName"];

                      if($_SESSION["level"]=="admin"){ 
                        $_SESSION['status'] = "เข้าสู่ระบบสำเร็จ !";
                        $_SESSION['status_code'] = "success";
                        Header("Location: ../home.php");
                      }
                      if ($_SESSION["level"]=="employee"){ 
                        $_SESSION['status'] = "เข้าสู่ระบบสำเร็จ !";
                        $_SESSION['status_code'] = "success";
                        Header("Location: ../home.php");
                      }
                  }else{
                    $_SESSION['status'] = "รหัสผ่านไม่ถูกต้อง !";
                    $_SESSION['status_code'] = "error";
                    header('Location: ../index.php');
 
                  }
        }else{

             Header("Location: index.php"); //user & password incorrect back to login again
 
        }
?>