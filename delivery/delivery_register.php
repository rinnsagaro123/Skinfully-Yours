<?php

require  '../components/config.php';

session_start();

$message[] = '';
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   }else{
      $user_id = '';
   };

   if(isset($_POST["submit"])){

      $name = $_POST["name"];
      $name = filter_var($name, FILTER_SANITIZE_STRING);    
      $user = $_POST["user"];
      $user = filter_var($user, FILTER_SANITIZE_STRING);
      $email = $_POST["email"];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $pass = $_POST["pass"];
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);
      $cpass = $_POST["confirmpass"];
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

      $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
      $hashed_cpassword = password_hash($cpass, PASSWORD_DEFAULT);
   
      $select_user = $conn->prepare("SELECT * FROM `riders_user` WHERE user = ? OR pass = ?");
      $select_user->execute([$user, $pass]);
      $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
      if($select_user->rowCount() > 0)
      {
         echo $message[] = 'username or password already exists!';
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
            $insert_user = $conn->prepare("INSERT INTO `riders_user` (name, email, user, pass, confirmpass) VALUES(?,?,?,?,?)");
            $insert_user->execute([$name, $email, $user, $hashed_password, $hashed_cpassword]);

            $select_user = $conn->prepare("SELECT * FROM `riders_user` WHERE user = ? OR pass = ?");
            $select_user->execute([$user, $pass]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);
               if($select_user->rowCount() > 0)
               {
                  $message[] = 'Registration Successful!';
                  // header('location:delivery_login.php');
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
    <title>Skinfully Yours Xpress | Register</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
    />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" 
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../style/style.css?v=<?php echo time(); ?>">

</head>
<body>



<section class="form-container">
    <br><br><br><br>
        <br><br><br><br>
<form class="" actions="" method="POST" autocomplete="off" id="input_form">
           <h3>register now</h3>

           <?php
            if (isset($error)) {
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            }
            ?> 
      <input type="text" name="name" id="name" class="box" maxlength="50" maxlength="50" required placeholder="Enter your Name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>">

      <input type="text" name="user" id="user" class="box" maxlength="50" required placeholder="Enter your Username" value="<?php if(isset($_POST['user'])) echo $_POST['user']; ?>">


      <input type="email" name="email" id="email" class="box" maxlength="50" required placeholder="Enter your Email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">

      <input type="password" name="pass" id="pass" class="box" maxlength="50" required placeholder="Enter your Password"> 
   
      <input type="password" name="confirmpass" id="confirmpass" class="box" maxlength="50" required placeholder="Confirm Password"> 

      <button type="submit" name="submit" class="btn" id="submit"> Register Now </button>
      <p>already have an account? <a href="delivery_login.php">login now</a></p>
        </form>
     
     </section>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"> </script>


<?php include '../components/delivery_footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script src="js/delivery_script.js?v=<?php echo time(); ?>"></script>
</body>
</html>