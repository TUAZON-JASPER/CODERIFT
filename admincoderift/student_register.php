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

    $sql_insert_student = "INSERT INTO students (name, year_level, section) VALUES ('$student_name', '$year_level', '$section')";
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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
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
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Code Rift - Student Registration</a>
    </nav>

    <!-- Registration Form -->
    <div class="container">
        <h2 class="text-center mb-4">Student Registration</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>