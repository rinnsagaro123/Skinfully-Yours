<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };
 
 include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully yours | Products</title>

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


<section class="products"> 

<br><br>
<h1 class="title">Products</h1>

   <div class="box-container">
  

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="description" value="<?= $fetch_products['description']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         
         <div class="image">
            <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>"><img src="uploaded_img/<?= $fetch_products['image']; ?>" alt=""></a>
            <div class="icons">
            <button type="submit" class="cart-btn" name="add_to_cart">Add to cart</button>
            </div>
         </div>

         <div class="cat"><a href="category.php?category=<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></a> </div>
         
         <div class="name"><a><?= $fetch_products['name']; ?></div></a>
        
         <!-- <div class="desc"> <?= $fetch_products['description']; ?> </div> -->
         
         <div class="flex">
            <div class="price"><a><span>₱</span><?= $fetch_products['price']; ?></a></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>

    
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>