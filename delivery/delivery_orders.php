<?php

include '../components/config.php';

session_start();

if(isset($_SESSION['rider_user_id'])){
    $user_id = $_SESSION['rider_user_id'];
 }else{
    $user_id = '';
    header("location: delivery_login.php");
 };
 
//  include 'components/add_cart.php';




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
    <link rel="stylesheet" href="../style/delivery_style.css?v=<?php echo time(); ?>">
    <title> Skinfully Yours Xpress | Orders </title>
</head>

<body>


<?php include '../components/delivery_header.php'; ?>



   <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
  
    <div class="box">
   <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
    </form>
      <p>order number : <span><?= $fetch_orders['id']; ?></span></p>
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>₱<?= $fetch_orders['total_price']; ?>/-</span></p>
    
      <button type="submit" name="accept" id="accept">Accept</button>
      <button type="submit" name="decline" id="decline">Decline</button>
      
   </div>   
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>
</div>
    </section>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
 integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>