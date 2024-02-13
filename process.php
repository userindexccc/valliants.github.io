<?php
// Establish a database connection
$conn = new mysqli("localhost", "root", "", "admin");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 

//sanitizing 
function sanitizes($input)
{
    $input = trim($input);
    $input =  htmlspecialchars($input);
    $input = mysqli_real_escape_string($GLOBALS['conn'], $input);
    return $input;
}

// Get user input from the form
$cccid =  sanitizes($_POST['cccid']);
$name = sanitizes($_POST['name']);
$email = sanitizes($_POST['email']);
$age = sanitizes($_POST['age']);
$gender = sanitizes($_POST['gender']);


$sports = isset($_POST['sports']) ? implode(",", $_POST['sports']) : '';

if (empty($sports)) {
    echo "<script>alert('Please select at least one sport');</script>";
    echo "<script>document.location='Forms.php';</script>";
    exit;
} 

$existingUser = "SELECT * FROM users WHERE email = '$email'";
$existinguserresult = $conn -> query($existingUser);

if ($existinguserresult->num_rows > 0) {
    // echo "Error: This email address is already registered. <a href='Forms.php'>Back to the form</a>";
    echo "<script>alert('This email address is already registered!!');</script>";
  echo "<script>document.location='Forms.php';</script>";
} else {

    // Insert data into the database
    $sql = "INSERT INTO users (cccid, name, email, age, gender, sports) VALUES ('$cccid', '$name', '$email', $age, '$gender', '$sports')";
    
    //checking if true
    if ($conn->query($sql) === TRUE) {
        // echo "Registration successful! <a href='Forms.php'>Back to the form</a>";
         echo "<script>alert('Registration successful!');</script>";
        echo "<script>document.location='Forms.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Insert data into the database


$conn->close();
?>
<script> alert('Data Inserted'); </script>

