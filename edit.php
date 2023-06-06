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


// Retrieve the registration number from the URL parameter or form submission
$registrationNumber = $_GET['registration_number'];

// Write the SQL query to select the student's information based on the registration number
$sql = "SELECT * FROM students WHERE registration_number = '$registrationNumber'";

// Execute the SQL statement
$result = $conn->query($sql);

// Check if a student record is found
if ($result->num_rows == 0) {
    // Handle the case when the student record is not found, such as displaying an error message or redirecting to an error page
} else {
    // Fetch the student's information from the database
    $student = $result->fetch_assoc();

    // Display the student's information in the form fields
    // Assign the student's information to variables for displaying in the form
    $registrationNumber = $student['registration_number'];
    $name = $student['name'];
    $grade = $student['grade'];
    $classroom = $student['classroom'];

    // Display the form with the student's information pre-filled in the input fields
    // ...

    // Example: Output the student's information
    echo "Registration Number: " . $registrationNumber . "<br>";
    echo "Name: " . $name . "<br>";
    echo "Grade: " . $grade . "<br>";
    echo "Classroom: " . $classroom . "<br>";
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>

    <form action="process_edit.php" method="POST">
        <div>
            <label for="registration_number">Registration Number:</label>
            <input type="text" id="registration_number" name="registration_number" readonly>
        </div>
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="grade">Grade:</label>
            <input type="number" id="grade" name="grade" min="0" max="10" required>
        </div>
        <div>
            <label for="classroom">Classroom:</label>
            <input type="text" id="classroom" name="classroom" required>
        </div>
        <div>
            <input type="submit" value="Update">
        </div>
    </form>

</body>
</html>
