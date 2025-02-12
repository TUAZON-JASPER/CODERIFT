<?php
// Start the session
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "testdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Check if username exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Username not found!";
        header("Location: login.php");
        exit();
    } else {
        // Fetch the user data
        $row = $result->fetch_assoc();
        $hashed_password = $row['password']; // Get the hashed password from the database

        // Verify the entered password
        if (password_verify($pass, $hashed_password)) {
            // Successful login, save session and redirect to account page
            $_SESSION['username'] = $user;
            header("Location: menu.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['error'] = "Incorrect password!";
            header("Location: login.php");
            exit();
        }
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
