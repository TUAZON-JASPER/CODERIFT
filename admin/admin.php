<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Initialize an error variable to store messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin2 WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['username'] == $username && $row['password'] == $password) {
            header('location: index.php');
        }
    } else {
        $error = "No user found with that username.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: url('../img/menu.svg') no-repeat center center;
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            width: 100%;
            max-width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #800000;
            /* Maroon color */
            font-size: 1.8rem;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            font-size: 1rem;
            font-weight: bold;
            color: #800000;
            /* Maroon text */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #800000;
            /* Maroon border */
            border-radius: 8px;
            font-size: 1rem;
            margin-top: 5px;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #a05d5d;
            /* Lighter maroon on focus */
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #800000;
            /* Maroon background */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a05d5d;
            /* Lighter maroon on hover */
        }

        #error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 20px;
                width: 100%;
                max-width: 90%;
            }
        }
        a{
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <a href="../index.php">
            <h2>Admin Login</h2>
        </a>
        <form id="loginForm" action="admin.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php if ($error): ?>
            <p id="error-message"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>