<?php


$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ""; // Initialize an error variable to store messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match. Please try again.";
    } else {
        // Check if the username already exists
        $sql_check = "SELECT * FROM user WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param('s', $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Username already exists
            $error = "Username is already taken. Please choose a different one.";
        } else {
            // Insert new user
            $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);

            if ($stmt->execute()) {
                header('Location: index.php');
                exit();
            } else {
                $error = "Error occurred while creating your account.";
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="http://localhost/coderift/img/CR.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/coderift/css/login.css">
    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }
    </script>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: url('./img/menu.svg') no-repeat center center;
            background-size: cover;
        }
    </style>
</head>

<body>
    <section class="form">
        <div class="container">
            <a href="index.php">
                <h1 style="color: white;">CODERIFT</h1>
            </a>
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <form action="signup.php" method="POST" onsubmit="return validateForm();">
                <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
                <input type="password" class="form-control" name="password" placeholder="Password" id="password"
                    required>
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password"
                    id="confirm_password" required>
                <button type="submit" class="btn" name="signup">Submit</button>
                <div id="alert"></div>
            </form>
        </div>
    </section>
</body>

</html>