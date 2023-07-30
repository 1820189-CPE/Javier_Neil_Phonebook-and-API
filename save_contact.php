<?php
// Retrieve the contact data from the request
$contactData = json_decode(file_get_contents('php://input'), true);

$conn = mysqli_connect('localhost', 'id21003522_admin0001', 'Admin123!', 'id21003522_admin');
// Prepare the SQL statement based on whether it's an insert or update
if (empty($contactData['id'])) {
  $sql = "INSERT INTO contacts (id, first_name, last_name, middle_name, address, phone_number, email, notes, owner) VALUES (NULL, '" . mysqli_real_escape_string($conn, $contactData['firstName']) . "', '" . mysqli_real_escape_string($conn, $contactData['lastName']) . "', '" . mysqli_real_escape_string($conn, $contactData['middleName']) . "', '" . mysqli_real_escape_string($conn, $contactData['address']) . "', '" . mysqli_real_escape_string($conn, $contactData['phoneNumber']) . "', '" . mysqli_real_escape_string($conn, $contactData['email']) . "', '" . mysqli_real_escape_string($conn, $contactData['notes']) . "', '')";
        $conn->query($sql);


} if (!empty($contactData['id'])) {
  $sql = "UPDATE contacts SET
            first_name = '" . mysqli_real_escape_string($conn, $contactData['firstName']) . "',
            last_name = '" . mysqli_real_escape_string($conn, $contactData['lastName']) . "',
            middle_name = '" . mysqli_real_escape_string($conn, $contactData['middleName']) . "',
            address = '" . mysqli_real_escape_string($conn, $contactData['address']) . "',
            phone_number = '" . mysqli_real_escape_string($conn, $contactData['phoneNumber']) . "',
            email = '" . mysqli_real_escape_string($conn, $contactData['email']) . "',
            notes = '" . mysqli_real_escape_string($conn, $contactData['notes']) . "'
          WHERE id = " . (int)$contactData['id'];
          // Execute the SQL statement
if (mysqli_query($conn, $sql)) {
  echo 'Contact saved successfully';
} else {
  echo 'Error: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
}


?>