<?php


require '../components/config.php'; 

session_start();

if(isset($_SESSION['riders_user_id'])){
   $riders_user_id = $_SESSION['riders_user_id'];
}else{
   $riders_user_id = '';
};

if(isset($_POST['user'])){

    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    $select_user = $conn->prepare("SELECT * FROM `riders_user` WHERE user = ?");
    $select_user->execute([$user]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
 
    if($select_user->rowCount() > 0){
       $_SESSION["login"] = true;
       $_SESSION['riders_user_id'] = $row['id'];
       header('location:delivery_index.php');
    }else{
       echo $message[] = 'incorrect username or password!';
    }
 
 }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours Xpress | Sign In</title>
    <link rel="stylesheet" href="../style/style.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="form-container">
        <form class="" actions="" method="POST" autocomplete="off"> 
            <h1>Sign In</h1>
            <?php
            if (isset($error)) {
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                }
            }
            ?>
            <input type="text" id="user" name="user" required placeholder="Enter your Username " class="box" maxlength="50" 
            oninput="this.value= this.value.replace(/\s/g, '')" value="<?php if(isset($_POST['user'])) echo $_POST['user']; ?>">
            <input type="password" id="pass" name="pass" required placeholder="Enter your Password" class="box" maxlength="50" 
            oninput="this.value= this.value.replace(/\s/g, '')">
            <button type="submit" id="btnLogin" class="btn btn-submit" value="submit" name="submit">Submit</button>
            <p>don't have an account? <a href="delivery_register.php">Sign Up</a></p>
        </form>
    </div>


</body>
</html>