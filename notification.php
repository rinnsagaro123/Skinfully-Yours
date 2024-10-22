<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };

 if(isset($_POST['submit'])){

    $order_id = $_POST['oid'];
    $user_id = $_POST['user_id'];
    $order_no =  $_POST['oid'];
    $placed_on = $_POST['placed_on'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $method = $_POST['method'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];
    $payment_status = $_POST['payment_status'];
    $notif = $_POST['notify'];
    $notif = filter_var($notif, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $from = $_POST['from'];
    $from = filter_var($from, FILTER_SANITIZE_STRING);  
    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING); 
    $order_number = $_POST['order_number'];
    $order_number = filter_var($order_number, FILTER_SANITIZE_STRING); 
    $notify_rider = $_POST['notify_rider'];
    $notify_rider = filter_var($notify_rider, FILTER_SANITIZE_STRING); 
    $order_name = $_POST['order_name'];
    $order_name = filter_var($order_name, FILTER_SANITIZE_STRING); 
    $order_products = $_POST['order_products'];
    $order_products = filter_var($order_products, FILTER_SANITIZE_STRING); 
    $order_price = $_POST['order_price'];
    $order_price = filter_var($order_price, FILTER_SANITIZE_STRING); 
    $order_address = $_POST['order_address'];
    $order_address = filter_var($order_address, FILTER_SANITIZE_STRING); 
    $admin_id = $_POST['admin_id'];
    $admin_id = filter_var($admin_id, FILTER_SANITIZE_STRING); 

    $user_id = $_POST['user_id'];
    $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);  
    
    $update_notif = $conn->prepare("UPDATE `notification` SET `status` = 'seen' WHERE `notification`.`user_id` = ?");
    $update_notif->execute([$user_id]);

    $update_notif_rider = $conn->prepare("INSERT INTO `notify` (`id`, `user_id`, `admin_id`, `order_number`, `order_name`, `order_products`, `order_price`, `order_address`, `notify_rider`, `notify`, `status`, `from`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    $update_notif_rider ->execute([$user_id, $admin_id,  $order_number, $order_name, $order_products, $order_price, $order_address, $notify_rider, $notif, $status, $from]);
   
    $delete_notif = $conn->prepare("DELETE FROM `notification` WHERE user_id = ?");
    $delete_notif->execute([$user_id]);    

    // header("location: pending_ship.php");

    
    
    }

    if(isset($_POST['submited'])){

        $user_id = $_POST['user_id'];
        $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);  

        $update_notif = $conn->prepare("UPDATE `notify` SET `status` = 'seen' WHERE `notify`.`user_id` = ?");
        $update_notif->execute([$user_id]);   
        
        header("location: pending-receive.php");
   
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
    <title> Skinfully Yours | Notification </title>
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="notification">
<h1 class="heading">Notification</h1>
    <div class="box-container">
        <div class="box">
  
        <?php
              if($user_id == ''){
                echo '<p class="empty">please login first!</p>';
              }else
               {
               
                $notification = $conn->prepare("SELECT * from `notification` Where admin_id = 1 and status='unseen'");
                $notification->execute();
                    if($notification->rowCount() > 0)
                    {
                    while($fetch_notif = $notification->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <div class="box">
                       
                        <h3><span><?= $fetch_notif['notify']; ?></span></h3>
                        <h3><span>Order number: <?= $fetch_notif['order_number']; ?></span></h3>

                        <form action="" method="POST">
                        <input type="hidden" name="user_id" value="<?= $fetch_notif['user_id']; ?>">
                        <input type="hidden" name="notify_ship" value="<?= $fetch_notif['notify']; ?>"><form action="" method="POST"  class="box">

                        <input type="hidden" name="riders_user_id" value="<?= $fetch_notif['riders_user_id']; ?>"> 
                        <input type="hidden" name="oid" value="<?= $fetch_notif['id']; ?>">
                        <input type="hidden" name="user_id" value="<?= $fetch_notif['user_id'];  ?>">
                        <input type="hidden" name="placed_on" value="<?= $fetch_notif['placed_on'];  ?>">
                        <input type="hidden" name="name" value="<?= $fetch_notif['name'];  ?>">
                        <input type="hidden" name="number" value="<?= $fetch_notif['number'];  ?>">
                        <input type="hidden" name="address" value="<?= $fetch_notif['address'];  ?>">
                        <input type="hidden" name="method" value="<?= $fetch_notif['method'];  ?>">
                        <input type="hidden" name="total_products" value="<?= $fetch_notif['total_products'];  ?>">
                        <input type="hidden" name="total_price" value="<?= $fetch_notif['total_price'];  ?>">
                        <input type="hidden" name="payment_status" value="To Receive">
                        <input type="hidden" name="notify" value="Your order is on its way">
                        <input type="hidden" name="notify_rider" value="You accepted the order! Here is the list of order">
                        <input type="hidden" name="order_name" value="<?= $fetch_notif['name']; ?>">
                        <input type="hidden" name="order_products" value="<?= $fetch_notif['total_products']; ?>">
                        <input type="hidden" name="admin_id" value="<?= $fetch_notif['admin_id']; ?>">
                        <input type="hidden" name="order_price" value="<?= $fetch_notif['total_price']; ?>">
                        <input type="hidden" name="order_address" value="<?= $fetch_notif['address']; ?>">
                        <input type="hidden" name="status" value="unseen">
                        <input type="hidden" name="user" value="<?= $fetch_notif['user_id']; ?>">
                        <input type="hidden" name="order_number" value="<?= $fetch_notif['id']; ?>">
                        <input type="hidden" name="from"   value="username: <?= $fetch_notif['user_id']; ?>, order number: <?= $fetch_notif['id']; ?>">
                        <input type="hidden" name="status" value="unseen">
                        <input type="submit" name="submit" value="See" class="btn">
                     </div>

        <?php
        }} else 
        {
            $notif = $conn->prepare("SELECT * from `notify` Where admin_id = 1 and status='unseen'");
            $notif->execute();
            if($notif->rowCount() > 0)   
            {
            while($fetch_notif = $notif->fetch(PDO::FETCH_ASSOC)){

            ?>  
            <div class="box">
                
                <h3><span><?= $fetch_notif['notify']; ?></span></h3>
                <h3><span>Order number: <?= $fetch_notif['order_number']; ?></span></h3>

                <form action="" method="POST">
                <input type="hidden" name="user_id" value="<?= $fetch_notif['user_id']; ?>">
                <input type="hidden" name="notify_ship" value="<?= $fetch_notif['notify']; ?>">
                <input type="hidden" name="riders_user_id" value="<?= $fetch_notif['riders_user_id']; ?>"> 
                <input type="hidden" name="status" value="unseen">
                <input type="submit" name="submited" value="See" class="btn">
            </div>
               
        <?php
        }}
        }
        
    } 
        ?>

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