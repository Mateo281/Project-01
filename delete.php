<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Retrieve the registration number from the URL parameter
$registrationNumber = $_GET['registration_number'];

// Write the SQL query to delete the student record based on the registration number
$sql = "DELETE FROM students WHERE registration_number = $registrationNumber";

// Execute the SQL query
if ($conn->query($sql) === TRUE) {
    echo "Student record deleted successfully.";
} else {
    echo "Error deleting student record: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

