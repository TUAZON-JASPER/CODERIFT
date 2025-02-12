// getLessons.php
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$sql = "SELECT * FROM lessons";
$result = mysqli_query($conn, $sql);

$lessons = [];
while ($row = mysqli_fetch_assoc($result)) {
    $lessons[] = $row;
}

echo json_encode($lessons);
?>