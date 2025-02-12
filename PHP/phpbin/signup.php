<?php
// Start the session
session_start();

// Display error message if it exists
if (isset($_SESSION['error'])) {
    echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']); // Clear the error after displaying it
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 50px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
        }

        .form-footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h2>Signup</h2>

    <!-- HTML form for signup -->
    <form action="signup.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Signup</button>
    </form>

    <div class="form-footer">
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

</body>
</html>

<?php
// Database connection and signup logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "testdb");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username already taken! Please choose a different username.";
        header("Location: signup.php");
        exit();
    } else {
        // Insert new user into the database with hashed password
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user, $hashed_password);

        if ($stmt->execute()) {
            // Successful signup, redirect to login page
            $_SESSION['username'] = $user;
            header("Location: login.php");
            exit();
        } else {
            // Handle error
            echo "Error: " . $stmt->error;
        }
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
