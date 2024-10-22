<?php

include '../components/config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | Sales Report</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../style/admin_style.css?v=<?php echo time(); ?>">

</head>
<body>

<?php include '../components/admin_header.php' ?>
<section class="dashboard">
    <h1 class="heading">Sales Report</h1>

    <div class="box-container">

        <div class="box">
        <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT SUM(total_price) as yearly_income FROM `orders` where year(placed_on) = year(now()) and payment_status='completed'");
         $select_pendings->execute(['Completed']);
         $fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC);
         $total_pendings += $fetch_pendings['yearly_income'];
         ?>
        <h3>Yearly Income</h3>
        <p> ₱  <?= $total_pendings ?></p>
        </div>

        <div class="box">
        <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT SUM(total_price) as monthly_income FROM `orders` where month(placed_on) = month(now()) and payment_status='completed'");
         $select_pendings->execute(['Completed']);
         $fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC);
         $total_pendings += $fetch_pendings['monthly_income'];
         ?>
        <h3>Monthly Income </h3>
        <p> ₱ <?= $total_pendings ?></p>
        </div>

        <div class="box">
        <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT SUM(total_price) as weekly_income FROM `orders` where week(placed_on) = week(now()) and payment_status='completed'");
         $select_pendings->execute(['Completed']);
         $fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC);
         $total_pendings += $fetch_pendings['weekly_income'];
         ?>
        <h3>Weekly Income </h3>
        <p> ₱ <?= $total_pendings ?> </p>
        </div>

        <div class="box">
        <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT SUM(total_price) as daily_income FROM `orders` where placed_on = curdate() and payment_status='completed'");
         $select_pendings->execute(['Completed']);
         $fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC);
         $total_pendings += $fetch_pendings['daily_income'];
         ?>
        <h3>Daily Income </h3>
        <p> ₱ <?= $total_pendings ?></p>
        </div> 
    </div>

</section>