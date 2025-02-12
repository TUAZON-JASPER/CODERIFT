<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'coderift';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_SESSION['username'];

$sql = "SELECT points FROM user where username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $points = $row['points'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/header.css"> -->
    <link rel="stylesheet" href="./css/font.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/categories.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: url('./img/start.svg') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .backbtn {
            height: 40px;
        }

        .title {
            font-size: 25px;
        }

        .java {
            border-color: #723030;
            background-color: #723030;
        }

        .cpp {
            border-color: #d46d0e;
            background-color: #d46d0e;
        }

        .cpp:hover {
            border-color: #1A4674;
            background-color: white;
        }

        .java:hover {
            border-color: #F58219;
            background-color: white;
        }
    </style>
    <title>Code Rift</title>
</head>

<body>
    <!-- HEADER -->
    <section class="navbar text-light border-body border-bottom" style="background-color: #723030;">
        <div class="back"><a href="menu.php"><img class="backbtn" src="./img/back2.png" alt="backbutton"></a></div>
        <div class="title">Programming Language</div>
        <div id="point"></div>
    </section>

    <section class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <!-- Column container to stack images -->
        <div class="text-center" style="transform: translateY(-8%);">
            <!-- C++ Logo -->
            <a href="./quiz/c++.php" class="d-block mb-4">
                <div class="cpp">
                    <img height="180px" src="./img/c++.png" alt="c++logo">
                </div>
            </a>
            <!-- Java Logo -->
            <a href="./quiz/java.php" class="d-block">
                <div class="java">
                    <img height="180px" src="./img/java.png" alt="javalogo">
                </div>
            </a>
        </div>
    </section>

    <script src="./questions.js"></script>
</body>



</html>