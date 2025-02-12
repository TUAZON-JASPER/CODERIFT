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

    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header('Location: menu.php');
            exit();
        } else {
            $error = "Invalid password. Please try again.";
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
    <title>Login</title>
    <link rel="icon" href="img/CR.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
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
            <form action="index.php" method="POST">
                <input type="text" class="form-control" name="username" placeholder="Username" id="username" required>
                <input type="password" class="form-control" name="password" placeholder="Password" id="password"
                    required>
                <button type="submit" class="btn">Log In</button>
                <a class="text-center" href="signup.php" id="signup">Create new account</a>
            </form>
            <div class="mt-3 text-center">
                <a class="btn btn-primary mx-2" href="./admin/admin.php">Sign in to Admin</a>
                <a class="btn btn-primary mx-2" href="./test/choose_profile.php">Sign in to Teacher Portal</a>
            </div>
        </div>
    </section>
</body>

</html>
