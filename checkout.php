<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
    header('location:home.php');
 };
 $date = date("Y-m-d");

 if(isset($_POST['submit'])){

  $date = date("Y-m-d");
  $placed_on = $date;
  $order_number= $_POST['order_number'];
  $order_number = filter_var($order_number, FILTER_SANITIZE_STRING);
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_STRING);
  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $method = $_POST['method'];
  $method = filter_var($method, FILTER_SANITIZE_STRING);
  $address = $_POST['address'];
  $address = filter_var($address, FILTER_SANITIZE_STRING);
  $total_products = $_POST['total_products'];
  $total_price = $_POST['total_price'];
  $notif = $_POST['notify'];
   $notif = filter_var($notif, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $from = $_POST['from'];
   $from = filter_var($from, FILTER_SANITIZE_STRING);  

  $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
  $check_cart->execute([$user_id]);

  if($check_cart->rowCount() > 0){

     if($address == ''){
        $message[] = 'please add your address!';
     }else if ($method == 'cash on delivery'){
        
       $insert_notif = $conn->prepare("INSERT INTO `notif` (`id`, `user_id`, `admin_id`, `riders_user`, `notify`, `status`, `from`) VALUES (NULL, ?, NULL, NULL, ?, ?, ?);");
       $insert_notif->execute([$user_id, $notif, $status, $from]);
    
        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, order_number, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $order_number, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on]);

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);
        $message[] = 'order placed successfully!';

      
        header("Location: order.php");
       
     } else if ($method == 'credit card'){
        
      $insert_notif = $conn->prepare("INSERT INTO `notif` (`id`, `user_id`, `admin_id`, `riders_user`, `notify`, `status`, `from`) VALUES (NULL, ?, NULL, NULL, ?, ?, ?);");
      $insert_notif->execute([$user_id, $notif, $status, $from]);
   
       $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, order_number, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?,?)");
       $insert_order->execute([$user_id, $order_number, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on]);

  
       $message[] = 'order placed successfully!';

     
       header("Location: credit_card.php");
    } else if($method == 'paypal')
    {
    $insert_notif = $conn->prepare("INSERT INTO `notif` (`id`, `user_id`, `admin_id`, `riders_user`, `notify`, `status`, `from`) VALUES (NULL, ?, NULL, NULL, ?, ?, ?);");
    $insert_notif->execute([$user_id, $notif, $status, $from]);
 
     $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, order_number, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?,?)");
     $insert_order->execute([$user_id, $order_number, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on]);

     $message[] = 'order placed successfully!';

   
     header("Location: credit_card.php");
     
  }else{
     $message[] = 'your cart is empty';
  }

}}

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours | Checkout</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
    />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" 
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">

</head>
<body>



<?php include 'components/header.php'; ?>


  <section class="checkout">
<br><br><br><br>
   <h1 class="title">order summary</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>cart items</h3>
      <?php
         $grand_total = 0;
         $ship_fee = '45';
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' (₱'.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']) + $ship_fee;
            

      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₱ <?= $fetch_cart['price']; ?> = <?= $fetch_cart['quantity']; ?> pc.</span></p>
      
      <?php
            }
         }else{
            echo '<center><h3 class="empty">your cart is empty!</h3></center>';
         }
      ?>
      <br>
      <p><span class="name"> Shipping Fee</span><span class="price"> ₱<?= $ship_fee; ?>

      <p class="grand-total"><span class="name">Total Price :</span><span class="price">₱<?= $grand_total; ?></span></p>
      <a href="cart.php" class="btn">View Cart</a>
   </div>
   
   <input type="hidden" name="order_number" value="<?= $fetch_profile['id'] ?>">
   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
   <input type="hidden" name="notify" value="There`s a new order!">
   <input type="hidden" name="status" value="unseen">
   <input type="hidden" name="from"   value="username: <?= $fetch_profile['name']; ?>, order number: <?= $fetch_profile['id']; ?>">
        

   <div class="user-info">
      <h3>Your Info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Update Info</a>
      <h3>Delivery Address</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">Update Address</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>Select Payment Method --</option>
         <option value="cash on delivery">Cash On Delivery</option>
         <option value="credit card">Credit Card</option>
         <option value="paypal">Paypal</option>
      </select>
  

      <input type="submit" value="Place Order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%;
            background-color: var(--black); color: var(--white);" name="submit">
   </div>

</form>
   
</section>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>