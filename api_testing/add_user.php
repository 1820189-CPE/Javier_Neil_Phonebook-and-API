<?php

include_once 'connect.php';
include_once 'db_class.php';

$db = new db();
$db = $db->get_connection();

$items = new db_test($db);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $phoneNumber = $_POST["phoneNumber"];

    // Attempt to add the user
    if ($items->addUser($firstname, $lastname, $gender, $age, $address, $phoneNumber)) {
        // Redirect to read_api.php after adding the user
        header("Location: read_api.php");
        exit;
    } else {
        echo "Failed to add user";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
</head>
<body>
    <h2>Add New User</h2>
    <form action="add_user.php" method="post">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" required><br>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" required><br>

        <label for="age">Age:</label>
        <input type="text" name="age" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" name="phoneNumber" required><br>

        <input type="submit" value="Add User">
    </form>
</body>
</html>
