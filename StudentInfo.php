
<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check session
if (!isset($_SESSION['studentID'])) {
    header("Location: index.php");
    exit();
}

$studentID = $_SESSION['studentID'];

// Database connection
$servername = "sql1.njit.edu";
$username = "na772";
$password = "PASSWORD";
$dbname = "na772";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Join Student and Transcript tables
$sql = "SELECT Student.Name, Student.ID,
Student.Major, Transcript.Course, Transcript.Grade
FROM Student
INNER JOIN Transcript
ON Student.ID = Transcript.ID
WHERE Student.ID = ?";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $studentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
</head>
<body>

<h1>Student Information</h1>

<table border="1" cellpadding="10">
<tr>
    <th>Name</th>
    <th>ID</th>
    <th>Major</th>
    <th>Course</th>
    <th>Grade</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".htmlspecialchars($row['Name'])."</td>";
    echo "<td>".htmlspecialchars($row['ID'])."</td>";
    echo "<td>".htmlspecialchars($row['Major'])."</td>";
    echo "<td>".htmlspecialchars($row['Course'])."</td>";
    echo "<td>".htmlspecialchars($row['Grade'])."</td>";
    echo "</tr>";
}
?>

</table>

<br>

<a href="index.php">
    <button type="button">HOME / BACK</button>
</a>

<?php
mysqli_close($con);
?>

</body>
</html>
