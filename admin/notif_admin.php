<?php

include '../components/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


if(isset($_POST['submit'])){

$user_id = $_POST['user_id'];
$user_id = filter_var($user_id, FILTER_SANITIZE_STRING);  

$update_notif = $conn->prepare("UPDATE `notif` SET `status` = 'seen' WHERE `notif`.`user_id` = ?");
$update_notif->execute([$user_id]);
header("location: product_approve.php");


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | Notification</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../style/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<section class="notification">
<h1 class="heading">Notification</h1>
    <div class="box-container">
    
        <div class="box">
  
        <?php
              if($admin_id == ''){
                echo '<p class="empty">please login first!</p>';
              }else
               {
  
                $notification = $conn->prepare("SELECT * FROM `notif` WHERE status = 'unseen' and notify ='there`s a new order!'");
                $notification->execute();
                if($notification->rowCount() > 0)
                {
                    while($fetch_notif = $notification->fetch(PDO::FETCH_ASSOC)){

                    ?>
                    <div class="box">
                        <h3><span><?= $fetch_notif['notify']; ?></span></h3>
                        <h3><span>User ID: <?= $fetch_notif['user_id']; ?></span></h3>

                        <form action="" method="POST">
                        <input type="hidden" name="user_id" value="<?= $fetch_notif['user_id']; ?>">
                        <input type="hidden" name="status" value="see">
                        <input type="submit" name="submit" value="See" class="btn">
                        </form>
                    </div>
                <?php
                }}}
                
                ?>
    
        
        </div>
        
    </div>

</section>

<!-- custom js file link  -->
<script src="../js/admin_script.js?v=<?php echo time(); ?>"></script>

</body>
</html>