<?php
include 'config.php';

$city_id = $_POST['city_data'];

$brgy = $conn->prepare("SELECT * FROM refbrgy WHERE citymunCode = $city_id");
$brgy->execute();

// $output="";
$output = '<option value="">Select Barangay</option>'; 
if($brgy->rowCount() > 0) { 
    while($brgy_row = $brgy->fetch(PDO::FETCH_ASSOC)) {
     $output .= '<option value="' . $brgy_row['brgyCode'] . '">' . $brgy_row['brgyDesc'] . '</option>';
 }};

echo $output;

?>
