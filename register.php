<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'id21003522_admin0001';
$DATABASE_PASS = 'Admin123!';
$DATABASE_NAME = 'id21003522_admin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	echo "<script>
        window.location.href='logIn.html';
        alert('Please complete the registration form');
        </script>";
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
    echo "<script>
        window.location.href='logIn.html';
        alert('Please complete the registration form');
        </script>";
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	echo "<script>
        window.location.href='logIn.html';
        alert('Email is not Valid!');
        </script>";
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
	echo "<script>
        window.location.href='logIn.html';
        alert('Username is not Valid!');
        </script>";
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	echo "<script>
        window.location.href='logIn.html';
        alert('Password must be between 5 and 20 characters long!');
        </script>";
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo "<script>
        window.location.href='logIn.html';
        alert('Username Already Exist');
        </script>";
	} else {
		// Username doesn't exists, insert new account
if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
	// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
	$stmt->execute();
	echo "<script>
        window.location.href='logIn.html';
        alert('Registered successfuly, You can now Log In');
        </script>";

} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo "<script>
        window.location.href='logIn.html';
        alert('Could not prepare statement!');
        </script>";
}
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	echo "<script>
        window.location.href='logIn.html';
        alert('Could not prepare statement!');
        </script>";
}
$con->close();
?>
