<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
    header('location:home.php');
 };
 
 if(isset($_POST['submit'])){

  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);
  $number = $_POST['number'];
  $number = filter_var($number, FILTER_SANITIZE_STRING);

  if(!empty($name)){
     $update_name = $conn->prepare("UPDATE `user` SET name = ? WHERE id = ?");
     $update_name->execute([$name, $user_id]);
  }

  if(!empty($email)){
     $select_email = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
     $select_email->execute([$email]);
     if($select_email->rowCount() > 0){
        $message[] = 'email already taken!';
     }else{
        $update_email = $conn->prepare("UPDATE `user` SET email = ? WHERE id = ?");
        $update_email->execute([$email, $user_id]);
     }
  }

  if(!empty($number)){
     $select_number = $conn->prepare("SELECT * FROM `user` WHERE number = ?");
     $select_number->execute([$number]);
     if($select_number->rowCount() > 0){
        $message[] = 'number already taken!';
     }else{
        $update_number = $conn->prepare("UPDATE `user` SET number = ? WHERE id = ?");
        $update_number->execute([$number, $user_id]);

        $message[] = 'Number updated successfully!';
     }
  }
  
  $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
  $select_prev_pass = $conn->prepare("SELECT pass FROM `user` WHERE id = ?");
  $select_prev_pass->execute([$user_id]);
  $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
  $prev_pass = $fetch_prev_pass['pass'];
  $old_pass = sha1($_POST['old_pass']);
  $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
  $new_pass = sha1($_POST['new_pass']);
  $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
  $confirm_pass = sha1($_POST['confirm_pass']);
  $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

  if($old_pass != $empty_pass){
     if($old_pass != $prev_pass){
        $message[] = 'old password not matched!';
     }elseif($new_pass != $confirm_pass){
        $message[] = 'confirm password not matched!';
     }else{
        if($new_pass != $empty_pass){
           $update_pass = $conn->prepare("UPDATE `user` SET confirmpass = ? WHERE id = ?");
           $update_pass->execute([$confirm_pass, $user_id]);
           $message[] = 'password updated successfully!';
        }else{
           $message[] = 'please enter a new password!';
        }
     }
  }  

}

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours | Update Profile</title>

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


<section class="form-container update-form">

   <form action="" method="post">
      <h3>update profile</h3>
      <input type="text" name="name" required placeholder="Enter your Name" value="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="Enter your Email" value="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="number" required placeholder="Enter your number" value="<?= $fetch_profile['number']; ?>" class="box" min="0" maxlength="11">
      <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <button type="submit" value="Update Now" name="submit" id="btnLogin" class="btn btn-submit" class="btn">  Update Now </button>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>