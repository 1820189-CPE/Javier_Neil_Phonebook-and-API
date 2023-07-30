<?php
// Retrieve the contact ID from the request
$contactId = $_GET['id'];

// Connect to the database
$conn = mysqli_connect('localhost', 'id21003522_admin0001', 'Admin123!', 'id21003522_admin');

// Check connection
if (mysqli_connect_errno()) {
  die('Database connection failed: ' . mysqli_connect_error());
}

// Fetch the contact with the specified ID
$sql = "SELECT * FROM contacts WHERE id = " . (int)$contactId;
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
  // Convert the contact data to JSON and send the response
  header('Content-Type: application/json');
  echo json_encode($row);
} else {
  echo 'Contact not found';
}

// Close the database connection
mysqli_close($conn);
?>
