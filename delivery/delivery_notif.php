<?php

include '../components/config.php';

session_start();

// $user_id = $_GET['user_id'];
// $admin_id = $_GET['admin_id'];

if(isset($_SESSION['riders_user_id'])){
    $riders_user_id = $_SESSION['riders_user_id'];
 }else{
    $riders_user_id = '';
 };


 if(isset($_POST['submit'])){

    $user_id = $_POST['user_id'];
    $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);  
    
    $update_notification = $conn->prepare("UPDATE `notification_rider` SET `status` = 'seen' WHERE `notification_rider`.`user_id` = ? and status='unseen'");
    $update_notification->execute([$user_id]);
    header("location: delivery_index.php");

}

if(isset($_POST['submited'])){

        $user_id = $_POST['user_id'];
        $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);  
        
        $update_notif = $conn->prepare("UPDATE `notif` SET `status` = 'seen' WHERE `notif`.`user_id` = ?");
        $update_notif->execute([$user_id]);
        header("location: delivery_todo.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/delivery_style.css?v=<?php echo time(); ?>">
    <title> Skinfully Yours Xpress | Notification </title>
</head>
<body>

<?php include '../components/delivery_header.php'; ?>

<section class="notification">
<h1 class="heading">Notification</h1>

<div class="box-container">
<div class="box">


<?php
      if($riders_user_id == ''){
        echo '<p class="empty">please login first!</p>';
      }else
       {
    //    $user_id = $_POST['user_id'];
    //    $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
        ?>
        
   

    <?php
        $notification = $conn->prepare("SELECT * from `notification_rider` Where admin_id = 1 and status='unseen'");
        $notification->execute();
            if($notification->rowCount() > 0)   
            {
            while($fetch_notif = $notification->fetch(PDO::FETCH_ASSOC)){

            ?>
           
                 <div class="box">
                <h3><span><?= $fetch_notif['notify_rider']; ?></span></h3>
                <h3><span>Order number: <?= $fetch_notif['order_number']; ?></span></h3>

                <form action="" method="POST">
                <input type="hidden" name="user_id" value="<?= $fetch_notif['user_id']; ?>">
                <input type="hidden" name="notify_ship" value="<?= $fetch_notif['notify']; ?>">
                <input type="hidden" name="status" id="value" value="unseen">
                <input type="submit" name="submit" id="value" value="See"> <br><br>
            </div>
        <?php
        }} else 
        {
            ?>

            <?php
            $notification = $conn->prepare("SELECT * from `notif` Where admin_id = 1 and status='unseen'");
            $notification->execute();
            if($notification->rowCount() > 0)   
            {
            while($fetch_notif = $notification->fetch(PDO::FETCH_ASSOC)){

            ?>
            
            <div class="box">
                <h3><span><?= $fetch_notif['notify_rider']; ?></span></h3>
                <h3><span>Order number: <?= $fetch_notif['order_number']; ?></span></h3>

                <form action="" method="POST">
                <input type="hidden" name="user_id" value="<?= $fetch_notif['user_id']; ?>">
                <input type="hidden" name="notify_ship" value="<?= $fetch_notif['notify']; ?>">
                <input type="hidden" name="status" id="value" value="unseen"><br>
                <input type="submit" name="submited" id="value" value="See"><br>
                </div>

            
        <?php
        }}
        }
       
    } 
        ?>


</div>
</div>


</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6e4c95bbe7.js" crossorigin="anonymous"></script>
<script src="../js/delivery_script.js?v=<?php echo time(); ?>"></script>

    </body>
</html>