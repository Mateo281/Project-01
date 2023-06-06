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

// Fetch the list of students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);


$registration_number = $name = $grade = $classroom = "";
$registration_numberErr = $nameErr = $gradeErr = $classroomErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $registration_number = sanitizeInput($_POST["registration_number"]);
    $name = sanitizeInput($_POST["name"]);
    $grade = sanitizeInput($_POST["grade"]);
    $classroom = isset($_POST["classroom"]) ? sanitizeInput($_POST["classroom"]) : '';


    // Validate registration number
    if (empty($registration_number)) {
        $registration_numberErr = "Registration number is required";
    }

    // Validate name
    if (empty($name)) {
        $nameErr = "Name is required";
    }

    // Validate grade
    if (empty($grade)) {
        $gradeErr = "Grade is required";
    } elseif (!is_numeric($grade) || $grade < 0 || $grade > 10) {
        $gradeErr = "Grade must be a number between 0 and 10";
    }

    // Validate classroom
    if (empty($classroom)) {
        $classroomErr = "Classroom is required";
    }

    // Insert data into the database if there are no validation errors
    if (empty($registration_numberErr) && empty($nameErr) && empty($gradeErr) && empty($classroomErr)) {
        $sql = "INSERT INTO students (registration_number, name, grade, classroom) VALUES ('$registration_number', '$name', '$grade', '$classroom')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to index.php after successful insertion
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function to sanitize user input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h1>Add Student</h1>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="registration_number">Registration Number:</label>
        <input type="text" name="registration_number" id="registration_number">
        <span class="error"><?php echo $registration_numberErr; ?></span>
        <br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <span class="error"><?php echo $nameErr; ?></span>
        <br><br>

        <label for="grade">Grade:</label>
        <input type="number" name="grade" id="grade" min="0" max="10">
        <form action="add.php" method="POST">
        <input type="submit" value="Add Student">
</form>

        