<?php

include 'components/config.php';

session_start();


if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
      header('location:login.php');
 };


if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'deleted all from cart!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}


$grand_total = 0;

?>
 




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours | Cart</title>

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

<Br><br>
  <div class="wrapper">
    <div class="project">
    <    <div class="shop">
            <?php
            $ship_fee = '45';
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post" class="box">
            <div class="box">
                <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                <div class="content">
                    <h3> <div class="name"><?= $fetch_cart['name']; ?></div></h3>
                     <h4>Price: ₱<?= $fetch_cart['price']; ?></h4>   
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                    <button type="submit" class="fas fa-edit" name="update_qty"></button>
                    
                        <div class="sub-total"> sub total : <span>₱<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
               
                        <button type="submit" class="btn-area" name="delete" onclick="return confirm('delete this item?');"><i aria-hidden="true" class="fa fa-trash"></i> <span class="btn2">Remove</span></button>
                    </div>
            </div>
            </form>
                <?php
                 
                 $grand_total += $sub_total;

                }
                  }else{
                  echo '<p class="empty">your cart is empty</p>';
                  }

                  ?>

                
        </div>


        
        <div class="right-bar">
                    <p><span>Merchandise Subtotal: </span><span>₱<?= $grand_total; ?></span></p>
                    <p><span>Shipping total:</span><span>₱<?= $ship_fee; ?></span></p>
                    <p><span>Total Payment</span><span>₱<?= $grand_total + $ship_fee; ?> </span></p>
                    <a href="checkout.php"><i class="fa fa-shopping-cart"></i>Checkout</a>

                    <div class="more-btn">
                    <form action="" method="post">
                    <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">Delete all</button>
                    </form> <br>
                    <a href="products.php" class="b#">Continue Shopping</a> </div>
        </div>
    </div>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>