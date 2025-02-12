<?php
// session_start();

// $conn = new mysqli('localhost', 'root', '', 'coderift');

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $error = "";  // Initialize error message

// $username = ""; //
// $password = ""; //


// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $username = ""; //
//     $password = ""; //
// $sql = 'SELECT username, password FROM admin WHERE username = ?, password = ?';
// $stmt = $conn->prepare($sql);
// $stmt->bind_param('ss', $username, $password);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows() > 0) {
//     header('location: index.php');
// }


// }

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding-top: 50px; }
        .container { max-width: 400px; margin: auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Admin Login</h2>

        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <!-- <form action="admin_login.php" method="POST"> -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" onclick="submit()">Login</button>
        <!-- </form> -->
    </div>

    <script>
        let username = document.getElementById('username');
        let password = document.getElementById('password');

        function submit(){
            if (username.value === admin && password.value === admin){
                window.location.href = 'index.php';
            }
        }
        
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
