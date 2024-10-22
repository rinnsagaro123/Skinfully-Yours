<?php
include 'config.php';
$region_id =   $_POST['region_data'];

$prov = $conn->prepare("SELECT * FROM refprovince WHERE regCode = $region_id");
$prov->execute();
    
$output = '<option value="">Select Province</option>';
if($prov->rowCount() > 0) { 
   while($prov_row = $prov->fetch(PDO::FETCH_ASSOC)) {
   $output .= '<option value="' . $prov_row['provCode'] . '">' . $prov_row['provDesc'] . '</option>';

   $prov_row['provDesc'] = $prov_name;
}};
echo $output;


