<?php

include '../components/config.php';

if(isset($_POST['do_login']))
{


 $email=$_POST['email'];
 $pass=$_POST['password'];
 $select_user = $conn->prepare("SELECT * FROM `riders_user` WHERE email = ?");
 $select_user->execute([$email]);
 if($row = $select_user->fetch(PDO::FETCH_ASSOC))
    {
        $_SESSION['email']=$row['email'];
        echo "success";
    }
       else
       {
        echo "fail";
       }
       exit();
    }

    ;
?>