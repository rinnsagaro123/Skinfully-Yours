<?php

require 'components/config.php';

session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };

 if(isset($_POST["submit"])){

    $name = $_POST["name"];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $user = $_POST["username"];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST["password"];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST["confirmpass"];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $hashed_cpassword = password_hash($cpass, PASSWORD_DEFAULT);
 
    $select_user = $conn->prepare("SELECT * FROM `user` WHERE user = ? OR pass = ?");
    $select_user->execute([$user, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0)
    {
       $message[] = 'username or password already exists!';
    }
    else
    {
       if($pass != $cpass)
       {
          echo $message[] = 'confirm password not matched!';
       }
       else
       {
          if ($pass == $cpass)
          {
          $insert_user = $conn->prepare("INSERT INTO `user` (name, email, user, pass, confirmpass) VALUES(?,?,?,?,?)");
          $insert_user->execute([$name, $email, $user, $hashed_password, $hashed_cpassword]);

          $select_user = $conn->prepare("SELECT * FROM `user` WHERE user = ? OR pass = ?");
          $select_user->execute([$user, $pass]);
          $row = $select_user->fetch(PDO::FETCH_ASSOC);
             if($select_user->rowCount() > 0)
             {
                $message[] = 'Registration Successful!';

                header("location: login.php");
             }
             else
             {
                $message[] = 'Password Does not Match';
                
             }
          }
       }
 
    }
 } 
?>



<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
    <title> Skinfully Yours | SignUp</title>
</head>
<body>

<?php include 'components/header.php'; ?>
    <div class="form-container">
            <form class="" actions="" method="POST" autocomplete="off">
            <h1>Sign Up</h1>
            <?php
            if (isset($error)) {
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            }
            ?>
            
            <form class="" actions="" method="POST" autocomplete="off">
            <input type="text" name="name" id="name" required placeholder="Enter your Name">

            <input type="email" name="email" id="email" required placeholder="Enter your email">

            <input type="text" name="username" id="username" required placeholder="Enter your Username"> 

            <input type="password" name="password" id="password" required placeholder="Enter your Password"> 

            <input type="password" name="confirmpass" id="confirmpass" required placeholder="Confirm Password"> 

            <button type="submit" name="submit"> Submit </button>
            <p>already have an account? <a href="login.php">Sign In</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6e4c95bbe7.js" crossorigin="anonymous"></script>
<script src="js/script.js?v=<?php echo time(); ?>"></script>

    </body>
</html>