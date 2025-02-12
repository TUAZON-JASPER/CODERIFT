// getStudents.php
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

$students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}

echo json_encode($students);
?>