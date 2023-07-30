<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'connect.php';
include_once 'db_class.php';

$db = new db();
$db = $db->get_connection(); // Use get_connection() method to get the database connection

$items = new db_test($db); // Pass the database connection to db_test constructor

$sysArr = array();
$sysArr["body"] = array(); // Correct array assignment syntax
$itemCount = 0;

$stmt = $items->readData(); // Call the readData() method to retrieve data

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $e = array(
        "id" => $row['id'],
        "firstname" => $row['firstName'],
        "lastname" => $row['lastName'],
        "gender" => $row['gender'],
        "age" => $row['age'],
        "address" => $row['address'],
        "phoneNumber" => $row['phoneNumber'],
    );

    array_push($sysArr["body"], $e);
    $itemCount++;
}

$sysArr["itemCount"] = $itemCount; // Assign the itemCount value after counting the items

echo json_encode($sysArr);
?>
