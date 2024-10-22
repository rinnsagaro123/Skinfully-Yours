<?php

include '../components/config.php';


?>

<section class="header">

    <!-- <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label> -->
    <!-- <div id = "container">

    <a href="#" class="logo"><img src="style/images/logo.png" width="80" height="70" class="d-inline-block align-top" alt=""></a>
    </div> -->
    <div id="container">
    <a href="delivery_index.php" class="logo">Skinfully Yours <span>Xpress</span></a></div>
    <nav class="navbar">
       
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
            $select_profile->execute([$riders_user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <a href="../delivery/delivery_index.php">Order</a> 
            <a href="../delivery/delivery_todo.php">To Do</a>
            <a href="../delivery/delivery_delivered.php">Delivered</a>
        <?php
            }
        ?>
    </nav>

    <div class="icon">

    <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$riders_user_id]);
            $total_cart_items = $count_cart_items->rowCount();

            $notification = $conn->prepare("SELECT * from `notification_rider` Where admin_id = 1 and status='unseen'");
            $notification->execute();
            if($count_notif = $notification->rowCount() > 0)
            {
                $count_notif = $notification->rowCount();
            }
            else
            {
                $notification = $conn->prepare("SELECT * from `notif` Where admin_id = 1 and status='unseen'");
                $notification->execute();
                $count_notif = $notification->rowCount();
            }
    ?>
        <div id="menu-btn" class="fas fa-bars" ></div>
        <div id="user-btn" class="fas fa-user"> </div>
        <a href="delivery_notif.php"><div id="notif-btn" class="fa-solid fa-bell position-relative"><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $count_notif; ?></span></div></a>
        
       

    </div>

    <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `riders_user` WHERE id = ?");
            $select_profile->execute([$riders_user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name" style="margin-left: 1.5rem;"> Welcome <?= $fetch_profile['name']; ?> </p>
                <div class="flex">
                    <a href="profile.php" class="btn-user"> Profile </a>
                    <a href="../delivery/delivery_logout.php" onclick="return confirm('Do you want to logout?')" class="btn-user"> Logout </a>

                </div>
         <?php
            }else{
         ?>
            <p class="name">please login first!</p>
            <a href="../delivery/delivery_login.php">Login</a>
            <a href="../delivery/delivery_register.php">SignUp</a>
         <?php
          }
         ?>
      </div>
</section>