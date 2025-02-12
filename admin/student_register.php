<?php
// Include database connection file
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

// Handle the student registration (Insert New Student)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_student'])) {
    $student_name = $_POST['name'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $password = $_POST['password'];

    // Hash the password before saving it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_insert_student = "INSERT INTO students (name, year_level, section, password) VALUES ('$student_name', '$year_level', '$section', '$hashed_password')";

    if ($conn->query($sql_insert_student) === TRUE) {
        // Redirect after successful registration to the confirmation page
        header('Location: registration_success.php');
        exit;
    } else {
        echo "Error: " . $sql_insert_student . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            max-width: 500px;
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 30px;
            border-radius: 10px;
        }

        .navbar {
            background-color: #800000;
        }

        .navbar-brand {
            color: white;
        }

        .navbar-light .navbar-nav .nav-link {
            color: white;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: #ffd700;
        }

        .btn-primary {
            background-color: #800000;
            border-color: #800000;
        }

        .btn-primary:hover {
            background-color: #d9534f;
            border-color: #d9534f;
        }

        .alert-danger {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Code Rift - Student Registration</a>
    </nav>

    <!-- Registration Form -->
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Student Registration</h2>
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <form method="POST" action="" onsubmit="return validateForm();">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="mb-3">
                    <label for="year_level" class="form-label">Year Level</label>
                    <select class="form-select" id="year_level" name="year_level" required>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="section" class="form-label">Section</label>
                    <select class="form-select" id="section" name="section" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="register_student">Register</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
