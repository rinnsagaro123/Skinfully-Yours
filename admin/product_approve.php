<?php

include '../components/config.php';

session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   header("location: decline_form.php");
}


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
   $payment_status_to_ship = $_POST['payment_status_to_ship'];
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




         $insert_order = $conn->prepare("UPDATE `orders` SET admin_id = ?, order_number = ?, payment_status = ? WHERE id = ?");
         $insert_order->execute([$admin_id, $order_no, $payment_status_to_ship, $order_id]);
 
         // $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         // $delete_cart->execute([$user_id]);
 
         $message[] = 'Approved!';
         if($admin_id == ''){
            echo '<p class="empty">please login first!</p>';
         }else{
      

        $update_notif = $conn->prepare("INSERT INTO `notification` (`id`, `user_id`, `admin_id`, `riders_user`, `order_number`, `order_name`, `order_products`, `order_price`, `order_address`, `notify_rider`, `notify`, `status`, `from`) VALUES (NULL, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $update_notif->execute([$user_id, $admin_id, $order_number, $order_name, $order_products, $order_price, $order_address, $notify_rider, $notif, $status, $from]);

        $update_notif_rider = $conn->prepare("INSERT INTO `notification_rider` (`id`, `user_id`, `admin_id`, `riders_user`, `order_number`, `order_name`, `order_products`, `order_price`, `order_address`, `notify_rider`, `notify`, `status`, `from`) VALUES (NULL, ?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $update_notif_rider ->execute([$user_id, $admin_id, $order_number, $order_name, $order_products, $order_price, $order_address, $notify_rider, $notif, $status, $from]);

        $delete_notif = $conn->prepare("DELETE FROM `notif` WHERE user_id = ?");
        $delete_notif->execute([$user_id]);    

        }


}

      


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | placed orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../style/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="placed-orders">
<div class="box-container">

<?php

 if($admin_id== ''){
    echo '<p class="empty">please login to see your orders</p>';
 }else{
      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = 'pending'");
      $select_orders->execute();
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
      <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
      
      
      <form action=" " method="POST" class="box">
         
         <input type="hidden" name="oid" value="<?= $fetch_orders['id']; ?>">
         <input type="hidden" name="user_id" value="<?= $fetch_orders['user_id']; ?>">
         <input type="hidden" name="placed_on" value="<?= $fetch_orders['placed_on']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_orders['name']; ?>">
         <input type="hidden" name="number" value="<?= $fetch_orders['number']; ?>">
         <input type="hidden" name="address" value="<?= $fetch_orders['address']; ?>">
         <input type="hidden" name="method" value="<?= $fetch_orders['method']; ?>">
         <input type="hidden" name="total_products" value="<?= $fetch_orders['total_products']; ?>">
         <input type="hidden" name="total_price" value="<?= $fetch_orders['total_price']; ?>">
         <input type="hidden" name="payment_status_to_ship" value="To ship">
         <input type="hidden" name="notify" value="Your order is being shipped!">
         <input type="hidden" name="notify_rider" value="Available orders to deliver!">
         <input type="hidden" name="order_name" value="<?= $fetch_orders['name']; ?>">
         <input type="hidden" name="order_products" value="<?= $fetch_orders['total_products']; ?>">
         <input type="hidden" name="order_price" value="<?= $fetch_orders['total_price']; ?>">
         <input type="hidden" name="order_address" value="<?= $fetch_orders['address']; ?>">
         <input type="hidden" name="status" value="unseen">
         <input type="hidden" name="user" value="<?= $fetch_orders['user_id']; ?>">
         <input type="hidden" name="order_number" value="<?= $fetch_orders['id']; ?>">
         <input type="hidden" name="from"   value="username: <?= $fetch_orders['user_id']; ?>, order number: <?= $fetch_orders['id']; ?>">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <input type="hidden" value="cancelled" name="payment_status">
         <input type="submit" name="submit" value="Approve" class="btn">
         <input type="submit" name="update_payment" value="Cancel Order" class="btn">

         
      </form>
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
<!-- custom js file link  -->
<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>

</body>
</html>