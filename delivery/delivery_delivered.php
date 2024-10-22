<?php

include '../components/config.php';

session_start();

$riders_user_id = $_SESSION['riders_user_id'];
if(isset($_SESSION['riders_user_id'])){
   $riders_user_id = $_SESSION['riders_user_id'];

}else{
   $riders_user_id = '';
   header("location: delivery_login.php");
};




?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours Xpress | Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/delivery_style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include '../components/delivery_header.php'; ?>


<!-- <div class="heading"> 
    <h3> Orders </h3>
</div> -->

<section class="placed_order">


   <div class="box-container">

   <?php
      if($riders_user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE riders_user = ? and payment_status = 'Completed'");
         $select_orders->execute([$riders_user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
      <div class="box">
      <p>order number : <span><?= $fetch_orders['id']; ?></span></p>
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>₱<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p> payment status : <?= $fetch_orders['payment_status']; ?></span> </p>
      </div>

   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>
     </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6e4c95bbe7.js" crossorigin="anonymous"></script>
<script src="../js/delivery_script.js?v=<?php echo time(); ?>"></script>
</body>
</html>