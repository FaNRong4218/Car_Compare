<?php
include('connect.php');
$sql = "SELECT * FROM car_model WHERE brand_ID={$_GET['brand']}";
$query = mysqli_query($conn, $sql);

$json = array();
while($result = mysqli_fetch_assoc($query)) {    
    array_push($json, $result);
}
echo json_encode($json);