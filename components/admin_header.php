<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="placed_orders.php">Orders</a>
         <a href="users_accounts.php">Users</a>
         <a href="messages.php">Messages</a>
         <a href="sales.php">Sales<a>
         
      </nav>

      <div class="icons">
      <?php

         $notification = $conn->prepare("SELECT * from `notif` where notify='there`s a new order!' and status ='unseen'");
         $notification->execute([$admin_id]);
         $count_notif = $notification->rowCount();
      ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="notif_admin.php"><div id="notif-btn" class="fa-solid fa-bell position-relative"><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $count_notif; ?></span></div></a>
         <div id="user-btn" class="fas fa-user"></div>
         

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">login</a>
            <a href="register_admin.php" class="option-btn">register</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>

</header>