<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id']) && isset($_POST['type'])) {
    $id = intval($_POST['delete_id']);
    $type = $_POST['type'];

    if ($type === 'question') {
        $sql_delete = "DELETE FROM questions WHERE id = ?";
    } elseif ($type === 'lesson') {
        $sql_delete = "DELETE FROM lessons WHERE id = ?";
    } else {
        die("Invalid delete request.");
    }

    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
