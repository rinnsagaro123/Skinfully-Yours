<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
    header('location:home.php');
 };

 if(isset($_POST['save_radio']))
 {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $card_name = $_POST['card_name'];
    $order_number = $_POST['order_number'];

    $insert_credit = $conn->prepare("INSERT INTO credit_card VALUES (NULL,?,?,?,?,?,?)");
    $insert_credit->execute([$user_id, $order_number, $card_name, $card_number, $expiry_date, $cvv]);
    
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);

    
    header("location: order.php");

 }

 if(isset($_POST['cancel']))
 {
    header("location: checkout.php");
 }
 ?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours | Checkout</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
</head>
<body>


<?php include 'components/header.php'; ?>
<section class="credit_card">
<?php

$order_qry = $conn->prepare("SELECT id FROM `orders` order by id DESC LIMIT 1");
$order_qry->execute();
$order_number = $order_qry->fetch(PDO::FETCH_ASSOC);

?>


<div class="box-container">
     
    <div class="box">
   
    <h1 class="heading">Card Details</h1>
    <form action="" method ="POST">
    <input type="hidden" name="user_id" value="<?=$user_id; ?>">
    <input type="hidden" name="order_number" value="<?=$order_number['id']; ?>">
    <input type="text" name="card_number" placeholder="Card Number">
    <input type="text" name="expiry_date" placeholder="Expiry Date(MM/YY)">
    <input type="text" name="cvv" placeholder="CVV">
    <input type="text" name="card_name" placeholder="Name on Card">
    
    <br>

    <button type="submit" name="save_radio" class="btn btn-primary">Submit </button>
    <button type="submit" name="cancel" class="btn btn-primary"> Cancel </button>
</div>  
</div>
</section>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6e4c95bbe7.js" crossorigin="anonymous"></script>
<script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>