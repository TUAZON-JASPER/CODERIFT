// getAnalytics.php
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

$sql = "SELECT year_level, section, COUNT(*) as student_count FROM students GROUP BY year_level, section";
$result = mysqli_query($conn, $sql);

$analyticsData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $analyticsData[] = $row;
}

echo json_encode($analyticsData);
?>

<script>
    // getAnalytics.php
    <?php
    include 'db_connection.php';

    $sql = "SELECT year_level, section, COUNT(*) as student_count FROM students GROUP BY year_level, section";
    $result = mysqli_query($conn, $sql);

    $analyticsData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $analyticsData[] = $row;
    }

    echo json_encode($analyticsData);
    ?>

</script>