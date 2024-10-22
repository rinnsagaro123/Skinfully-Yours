<?php

include 'config.php';

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
</head>

    <body>
<section class="header">

    <!-- <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label> -->

    <div class="flex">
    <a href="index.php" class="logo"><img src="style/images/logo.png" width="80" height="70" class="d-inline-block align-top" alt=""></a>

    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="index.php#about">About</a>
        <a href="index.php#contact">Contact</a>      
        <a href="products.php   ">Product</a>
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <a href="order.php">Order</a> 
        <?php
            }
        ?>
    </nav>

    <div class="icon">

    <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();

            $notification = $conn->prepare("SELECT * from `notification` Where admin_id = 1 and status='unseen'");
            $notification->execute();
            if($count_notif = $notification->rowCount() > 0)
            {
                $count_notif = $notification->rowCount();
            }
            else
            {
                $notification = $conn->prepare("SELECT * from `notify` Where admin_id = 1 and status='unseen'");
                $notification->execute();
                $count_notif = $notification->rowCount();
            }
    ?>


        <div id="menu-btn" class="fas fa-bars" ></div>
        <a href="search.php"><div class="fa-solid fa-magnifying-glass"></div></a>
        <a href="cart.php"><div class="fas fa-shopping-cart"><span>(<?= $total_cart_items; ?>)</span></div></a>
        <div id="user-btn" class="fas fa-user"> </div>
        <a href="notification.php"><div id="notif-btn" class="fa-solid fa-bell position-relative"><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $count_notif; ?></span></div></a>

    </div>

    <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name" style="margin-left: 1.5rem;"> Welcome <?= $fetch_profile['name']; ?> </p>
                <div class="flex">
                    <a href="profile.php" class="btn-user"> Profile </a>
                    <a href="components/user_logout.php" onclick="return confirm('Do you want to logout?')" class="btn-user"> Logout </a>

                </div>
         <?php
            }else{
         ?>
            <p class="name">please login first!</p>
            <a href="login.php">Login</a>
            <a href="signup.php">SignUp</a>
         <?php
          }
         ?>
        </div>
        </div>
</section>