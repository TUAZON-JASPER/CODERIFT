<?php
// Create a connection to the database
$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if admin account already exists
$sql_check_admin = "SELECT * FROM user WHERE role = 'admin'";
$result = $conn->query($sql_check_admin);

if ($result->num_rows == 0) {
    // Admin doesn't exist, so create one
    $username = 'admin';  // Default username
    $password = 'admin';  // Default password (plain text)

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new admin user
    $sql_insert_admin = "INSERT INTO user (username, password, role) VALUES (?, ?, 'admin')";
    $stmt = $conn->prepare($sql_insert_admin);
    $stmt->bind_param('ss', $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Admin account created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Admin account already exists.";
}

// Close the database connection
$conn->close();
?>
