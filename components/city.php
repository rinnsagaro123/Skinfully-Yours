<?php
include 'config.php';

$prov_id = $_POST['prov_data'];

$city =$conn->prepare("SELECT * FROM refcitymun WHERE provCode = $prov_id");
$city->execute();

// $output="";
$output = '<option value="">Select City</option>'; 
if($city->rowCount() > 0) { 
    while($city_row = $city->fetch(PDO::FETCH_ASSOC)) {
     $output .= '<option value="' . $city_row['citymunCode'] . '">' . $city_row['citymunDesc'] . '</option>';
 }};

echo $output;

?>