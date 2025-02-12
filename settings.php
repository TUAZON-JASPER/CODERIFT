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

// Capitalize only the first letter of the username
$username = $_SESSION['username'];
$username = ucfirst(strtolower($username)); // Make first letter uppercase, rest lowercase

$sql = "SELECT cpp, ceasy, cinter, cadv, java, jeasy, jinter, jadv FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ceasy = $row['ceasy'];
    $cinter = $row['cinter'];
    $cadv = $row['cadv'];
    $jeasy = $row['jeasy'];
    $jinter = $row['jinter'];
    $jadv = $row['jadv'];
}

$total_cplus = $ceasy + $cinter + $cadv;
$total_java = $jeasy + $jinter + $jadv;
$cplus_percentage = ($total_cplus / 30) * 100;
$java_percentage = ($total_java / 30) * 100;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/header.css">
    <link rel="stylesheet" href="./CSS/font.css">
    <link rel="stylesheet" href="./CSS/body.css">
    <link rel="stylesheet" href="./CSS/account.css">
    <link rel="stylesheet" href="./CSS/viewport.css">
    <link rel="stylesheet" href="./CSS/categories.css">
    <link rel="icon" href="http://localhost/coderift/img/CR.png">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: url('./img/menu.svg') no-repeat center center;
            background-size: cover;
        }

        .progress-bar {
            transition: width 0.5s ease-in-out;
        }

        .language {
            font-size: 20px;
        }

        .card {
            width: 100%;
            padding: 10px;
        }
    </style>
    <title>Code Rift</title>
</head>

<body>
    <section class="navbar text-light border-body border-bottom" style="background-color: #723030;">
        <div class="back"><a href="menu.php"><img class="backbtn" src="./img/back2.png" alt="backbutton"></a></div>
        <div class="title">Settings</div>
        <div id="logout"><a href="logout.php"><img class="path-icon" src="http://localhost/coderift/img/logout.png"
                    alt="Logout"></a></div>
    </section>

    <section id="user" class="text-center">
        <img id="avatar" src="http://localhost/coderift/img/fox.png" alt="User Avatar" class="img-fluid rounded-circle">
        <div id="username"><strong><?php echo htmlspecialchars($username); ?></strong></div>
    </section>

    <main id="mainbody">
        <div class="container">
            <!-- C++ Section -->

            <div class="card">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong class="language">C++</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                style="width: <?php echo $cplus_percentage; ?>%"></div>
                        </div>
                        <div><strong><?php echo $total_cplus; ?>/30</strong></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong>Easy:</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                style="width: <?php echo ($ceasy / 10) * 100; ?>%"></div>
                        </div>
                        <div><strong><?php echo $ceasy; ?>/10</strong></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong>Intermediate:</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                style="width: <?php echo ($cinter / 10) * 100; ?>%"></div>
                        </div>
                        <div><strong><?php echo $cinter; ?>/10</strong></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong>Advanced:</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                style="width: <?php echo ($cadv / 10) * 100; ?>%"></div>
                        </div>
                        <div><strong><?php echo $cadv; ?>/10</strong></div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Java Section -->
            <div class="card">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong class="language">Java</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                style="width: <?php echo $java_percentage; ?>%"></div>
                        </div>
                        <div><strong><?php echo $total_java; ?>/30</strong></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong>Easy:</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                style="width: <?php echo ($jeasy / 10) * 100; ?>%"></div>
                        </div>
                        <div><strong><?php echo $jeasy; ?>/10</strong></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong>Intermediate:</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                style="width: <?php echo ($jinter / 10) * 100; ?>%"></div>
                        </div>
                        <div><strong><?php echo $jeasy; ?>/10</strong></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-between">
                        <div><strong>Advanced:</strong></div>
                        <div class="progress flex-grow-1 mx-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                style="width: <?php echo ($jadv / 10) * 100; ?>%"></div>
                        </div>
                        <div><strong><?php echo $jeasy; ?>/10</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </main>



</body>

</html>