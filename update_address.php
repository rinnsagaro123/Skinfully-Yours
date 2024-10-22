<?php

include 'components/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
    header('location:home.php');
 };
 
$reg = $conn->prepare("SELECT * FROM refregion");
$reg->execute();




if(isset($_POST['submit'])){

  $address = $_POST['street-address'] .', '.$_POST['barangayName'].', '.$_POST['cityName'].', '.$_POST['provinceName'] . ','.$_POST['regionName'] .',  '. $_POST['country'] .'- '. $_POST['zip-code'];
  $address = filter_var($address, FILTER_SANITIZE_STRING);

  $update_address = $conn->prepare("UPDATE `user` set address = ? WHERE id = ?");
  $update_address->execute([$address, $user_id]);

    $message[] = 'Address Saved!';
}


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skinfully Yours | Update Address</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
    />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" 
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="style/style.css?v=<?php echo time(); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <script>
function selectRegion()
{
    var d = document.getElementById("region");
    var displaytext=d.options[d.selectedIndex].text;
    document.getElementById("regionName").value=displaytext;

}

function selectProv()
{
    var d = document.getElementById("province");
    var displaytext=d.options[d.selectedIndex].text;
    document.getElementById("provinceName").value=displaytext;

}

function selectCity()
{
    var d = document.getElementById("city");
    var displaytext=d.options[d.selectedIndex].text;
    document.getElementById("cityName").value=displaytext;

}

function selectBrgy()
{
    var d = document.getElementById("barangay");
    var displaytext=d.options[d.selectedIndex].text;
    document.getElementById("barangayName").value=displaytext;

}
  
    </script>


</head>
<body>



<?php include 'components/header.php'; ?>


<section class="form-container">

<form class="" actions="" method="POST" autocomplete="off">
        <h3>Your Address</h3>
       <!-- <?php
        if (isset($error)) {
            foreach($error as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            }
        }
        ?> -->
        
        <input type="text" class="box" value="Philippines" 
        required maxlength="50" name="country">

                    <select name="region" id="region" class="box" onchange="selectRegion();">
                    <option selected="selected"> Select Region </option>

                    <?php while ($row = $reg->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option name="region1" value="<?php echo $row['id']; ?>"> <?php echo $row['regDesc']; echo" "; echo 
                            $row['regCode']; ?> </option>

                        <?php endwhile; ?>

                    <input type="hidden" id="regionName" name="regionName"> 
                    </select>


                    <select name="province" id="province" class="box" onchange="selectProv();">
                     
                        <option selected disabled="selected"> Select Province </option>

                        <input type="hidden" id="provinceName" name="provinceName"> 
                    </select>

 

  
                    <select name="city" id="city" class="box" onchange="selectCity();">

                        <option selected disabled="selected"> Select City </option>

                        <input type="hidden" id="cityName" name="cityName"> 
                    </select>

                  


                    <select name="barangay" id="barangay" class="box" onchange="selectBrgy();">

                        <option selected disabled="selected"> Select Barangay </option>

                        <input type="hidden" id="barangayName" name="barangayName"> 
                    </select>

        <input type="text" class="box" placeholder="Street Address" 
        required maxlength="50" name="street-address">
        
        <input type="text" class="box" placeholder="Zip Code" 
        required maxlength="50" name="zip-code">

        <!-- <p>Forget your password <a href="#"> Click Here  </a></p> -->
        <button type="submit" value="save address" name="submit" id="btnLogin" class="btn btn-submit" class="btn"> Update Address </button>
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script src="js/script.js?v=<?php echo time(); ?>"></script>

</body>
</html>

<script>
$('#region').on('change', function() {
      var region_id = this.value;
      console.log(region_id);
      $.ajax({
          url: 'components/province.php',
          type: "POST",
          data: {
              region_data: region_id
          },
          success: function(result) {
              $('#province').html(result);
              console.log(result);
              
          }
      })
    });
    
    $('#province').on('change', function() {
      var prov_id = this.value;
      console.log(prov_id);
      $.ajax({
          url: 'components/city.php',
          type: "POST",
          data: {
              prov_data: prov_id
          },
          success: function(data) {
              $('#city').html(data);
              console.log(data);
          },
          error: function (request, error) {
          console.log(arguments);
          alert(" Can't do because: " + error);
      }
      })
    });
    
    $('#city').on('change', function() {
      var city_id = this.value;
      console.log(city_id);
      $.ajax({
          url: 'components/barangay.php',
          type: "POST",
          data: {
              city_data: city_id
          },
          success: function(data) {
              $('#barangay').html(data);
              console.log(data);
          },
          error: function (request, error) {
          console.log(arguments);
          alert(" Can't do because: " + error);
      }
      })
    });

    </script>