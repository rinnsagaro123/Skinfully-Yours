<?php

$msg = '';
require 'components/config.php'; 

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['user'])){

    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `user` WHERE user = ?");
    $select_user->execute([$user]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $_SESSION["login"] = true;
       $_SESSION['user_id'] = $row['id'];
       header('location:index.php');
    }else{
       $message[] = 'incorrect username or password!';
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
    <title> Skinfully Yours | Login </title>
</head>
<body>

<?php include 'components/header.php'; ?>

    <div class="form-container">
        <form class="" actions="" method="POST" autocomplete="off"> 
            <h1>Sign In</h1>
            <?php
            if (isset($error)) {
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            }
            ?>
            <input type="text" id="user" name="user" required placeholder="Enter your Username " class="box" maxlength="50" 
            oninput="this.value= this.value.replace(/\s/g, '')">
            <input type="password" id="pass" name="pass" required placeholder="Enter your Password" class="box" maxlength="50" 
            oninput="this.value= this.value.replace(/\s/g, '')">
            <button type="submit" id="btnLogin" class="btn btn-submit" value="submit" name="submit">Submit</button>
            <p>don't have an account? <a href="signup.php">Sign Up</a></p>
        </form>
    </div>


    
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6e4c95bbe7.js" crossorigin="anonymous"></script>
<script src="js/script.js?v=<?php echo time(); ?>"></script>

    </body>
</html>