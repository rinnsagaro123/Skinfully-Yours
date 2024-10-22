<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };
 
//  include 'components/add_cart.php';

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
    $notif = $_POST['notify'] . ' ' .$_POST['name'];
    $notif = filter_var($notif, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $from = $_POST['from'];
    $from = filter_var($from, FILTER_SANITIZE_STRING);   

 
    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);
 
    if($select_message->rowCount() > 0){
       $message[] = 'already sent message!';
    }else{
        if($user_id == ''){
            echo '<p class="empty">please login to see your orders</p>';
         }else{
       $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
       $insert_message->execute([$user_id, $name, $email, $number, $msg]);

       $message[] = 'sent message successfully!';

      
        $insert_notif = $conn->prepare("INSERT INTO `notif` (`id`, `user_id`, `admin_id`, `riders_user`, `notify`, `status`, `from`) VALUES (NULL, ?, NULL, NULL, ?, ?, ?);");
        $insert_notif->execute([$user_id, $notif, $status, $from]);
      
        $message[] = 'Notification!!!!';
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
    <title> Skinfully Yours </title>
</head>

    <body>


<?php include 'components/header.php'; ?>


<section class="home" id="home">

    <div class="content">
        <h3>Skinfully Yours</h3>
        <span> LET YOUR SKIN BREATHE </span>
        <div class="boxbox">
            <span>Need Skincare and tips?</span>
        </div>
        <p>We have a trusted consulting team of editors and experts worldwide to help your skin be in its fullest.</p>
    </div>
    
</section>

<section class="about" id="about">

    <h1 class="heading"> <span> About</span> Us </h1>

    <div class="row">
            <div class="video-container">
                <video src="style/images/production ID_1.mp4" loop autoplay muted></video>
                <h3>We are Legit!!!</h3>
            </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p align="justify">Skinfully Yours began as a humble brand of skincare catering Filipino beauty. The brand focuses on the
            idea of a skincare that suits the tropical climate in the Philippines. At the same time, making the brand
            affordable with the benefits of genuine natural ingredients..</p>

            <p align="justify">The idea of the business started with the idea of “skincare made for you, made for everyone”. With
            enough hard work and perseverance, Skinfully Yours is now an established skincare business. Each and
            every proponents behind this business worked continuously together to develop and establish a wider
            channel of skincare products. Skinfully Yours choose to serve the Filipinos to further show the world the
            beauty of the Filipino people. </p>

            <p align="center"> This is a skincare brand, made Skinfully Yours.</p>
        </div>

    </div>

</section>

<section class="icons-container">

    <div class="icons">
        <img src="style/images/free-delivery-free.svg" alt="">
        <div class="info">
            <h3>free delivery</h3>
            <span>on all orders</span>
        </div>
    </div>


    <div class="icons">
        <img src="style/images/securepayment.png" alt="">
        <div class="info">
            <h3>secure payments</h3>
            <span>protected by paypal</span>
        </div>
    </div>
   
</section>

<section class="contact" id="contact">

    <h1 class="heading"> <span> contact </span> us </h1>

    <div class="row">

        <form action="" method="post"> 
   
        <input type="text" name="name" maxlength="50" class="box" placeholder="name" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="number" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="email" required>
         <textarea name="msg" class="box" required placeholder="message" maxlength="500" cols="30" rows="10"></textarea>
         <input type="hidden" name="notify" value="Message Sent by">
         <input type="hidden" name="status" value="unseen">
         <input type="hidden" name="from"   value="message">
         <input type="submit" value="send message" name="send" class="btn">
        </form>

        <div class="image">
            <img src="style/images/contact-us-pic.png" alt="">
        </div>

    </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6e4c95bbe7.js" crossorigin="anonymous"></script>
<script src="js/script.js?v=<?php echo time(); ?>"></script>

    </body>
</html>