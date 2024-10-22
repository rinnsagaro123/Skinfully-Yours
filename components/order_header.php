<?php

include 'config.php';

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
    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">
</head>

    <body>

<header class="header-order">

   <div class="container">

   <navbar class="navbar-order">
      <div class ="item">
      <a href="order.php" class="heading">All</a></div>
      <div class ="item">
      <a href="pending-order.php" class="heading">Pay</a></div>
      <div class ="item">
      <a href="pending_ship.php" class="heading">ship</a></div><br>
      <div class ="item">
      <a href="pending-receive.php" class="heading">Receive</a></div>
      <div class ="item">
      <a href="completed-order.php" class="heading">Completed</a></div>
      <div class ="item">
      <a href="cancelled-order.php" class="heading">Cancelled</a></div>


   </navbar>

  <div id="menu-btn-order" class="fas fa-bars" ></div>
   </div>

</header>
