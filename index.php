
<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "sql1.njit.edu";
$username = "na772";
$password = "PASSWORD";
$dbname = "na772";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];

    // Check if student exists
    $sql = "SELECT * FROM Student WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $studentID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Create session variable
        $_SESSION['studentID'] = $studentID;

        // Redirect to second PHP script
        header("Location: studentInfo.php");
        exit();
    } else {
        echo "<script>alert('Student ID not found!');</script>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Search</title>
</head>
<body>

<h1>Student Search</h1>

<form method="POST" action="">
    <label>Enter Student ID:</label>
    <input type="number" name="studentID" required>
    <input type="submit" name="submit" value="Search">
</form>

</body>
</html>
