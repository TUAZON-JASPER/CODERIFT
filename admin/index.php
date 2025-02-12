<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql_insert_question = "INSERT INTO questions (question, answer) VALUES ('$question', '$answer')";
    if ($conn->query($sql_insert_question) === TRUE) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $sql_insert_question . "<br>" . $conn->error;
    }
}

// Handle Insert of a New Lesson
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_lesson'])) {
    $lesson_title = $_POST['lesson_title'];

    $sql_insert_lesson = "INSERT INTO lessons (title) VALUES ('$lesson_title')";
    if ($conn->query($sql_insert_lesson) === TRUE) {
        echo "New lesson added successfully!";
    } else {
        echo "Error: " . $sql_insert_lesson . "<br>" . $conn->error;
    }
}

// Fetch questions data from the database
$sql_questions = "SELECT id, question FROM questions";
$result_questions = $conn->query($sql_questions);
$questions = [];
if ($result_questions->num_rows > 0) {
    while ($row = $result_questions->fetch_assoc()) {
        $questions[] = $row;
    }
}

// Fetch lessons data from the database
$sql_lessons = "SELECT id, title FROM lessons";
$result_lessons = $conn->query($sql_lessons);
$lessons = [];
if ($result_lessons->num_rows > 0) {
    while ($row = $result_lessons->fetch_assoc()) {
        $lessons[] = $row;
    }
}

// Fetch student data from the database
$sql_students = "SELECT id, name, year_level, section FROM students";
$result_students = $conn->query($sql_students);
$students = [];
if ($result_students->num_rows > 0) {
    while ($row = $result_students->fetch_assoc()) {
        $students[] = $row;
    }
}

// Fetch analytics data for the chart (student registration analytics)
$sql_analytics = "SELECT year_level, section, COUNT(id) as student_count FROM students GROUP BY year_level, section";
$result_analytics = $conn->query($sql_analytics);
$analytics_data = [];
if ($result_analytics->num_rows > 0) {
    while ($row = $result_analytics->fetch_assoc()) {
        $analytics_data[$row['year_level']][$row['section']] = $row['student_count'];
    }
} else {
    $analytics_data = [
        '1st Year' => ['A' => 0, 'B' => 0],
        '2nd Year' => ['A' => 0, 'B' => 0]
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quiz Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            /* Light gray background for contrast */
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #800000;
            /* Maroon color */
        }

        .navbar-light .navbar-nav .nav-link {
            color: white;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: #ffd700;
            /* Gold color for hover effect */
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        /* Active nav-pill styling */
        .nav-pills .nav-link.active {
            background-color: #800000;
            color: white;
        }

        .nav-pills .nav-link {
            color: #800000;
            border-radius: 0;
            font-weight: bold;
        }

        .nav-pills .nav-link:hover {
            color: #ffd700;
        }

        /* Content Styling */
        .content {
            margin-top: 100px;
            /* Adjusted for navbar height */
        }

        .tab-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h4 {
            color: #800000;
            /* Maroon color for section titles */
            font-weight: bold;
        }

        /* Table Styling */
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .table-bordered th {
            background-color: #800000;
            /* Maroon header */
            color: white;
            font-weight: bold;
        }

        .table-bordered tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            border-radius: 4px;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #800000;
            /* Maroon button */
            border: none;
        }

        .btn-primary:hover {
            background-color: #660000;
            /* Darker maroon on hover */
        }

        .btn-danger {
            background-color: #dc3545;
            /* Red for delete buttons */
            border: none;
        }

        .btn-danger:hover {
            background-color: #b02a37;
            /* Darker red for hover */
        }

        .btn-success {
            background-color: #28a745;
            /* Green for add buttons */
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
            /* Darker green on hover */
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #800000;
            /* Maroon header */
            color: white;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-label {
            font-weight: bold;
        }

        .modal-body input[type="text"],
        .modal-body input[type="password"] {
            margin-bottom: 10px;
        }

        /* Card Styling for Analytics */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .card-header {
            background-color: #800000;
            color: white;
        }

        .card-body {
            background-color: #fff;
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="#">Code Rift Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        </li>
        <!-- Logout Button -->
        <li class="nav-item">
            <a href="../index.php">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </a>

            <!-- <form method="POST" action="logout.php" style="display:inline;">
            </form> -->
        </li>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <div class="container mt-4">
            <ul class="nav nav-pills mb-3" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="questions-tab" data-bs-toggle="pill" href="#questions" role="tab"
                        aria-controls="questions" aria-selected="true">Manage Questions</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="lessons-tab" data-bs-toggle="pill" href="#lessons" role="tab"
                        aria-controls="lessons" aria-selected="false">Manage Lessons</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="students-tab" data-bs-toggle="pill" href="#students" role="tab"
                        aria-controls="students" aria-selected="false">View Students</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="analytics-tab" data-bs-toggle="pill" href="#analytics" role="tab"
                        aria-controls="analytics" aria-selected="false">Analytics</a>
                </li>
            </ul>

            <div class="tab-content" id="dashboardTabsContent">
                <!-- Manage Questions Tab -->
                <div class="tab-pane fade show active" id="questions" role="tabpanel" aria-labelledby="questions-tab">
                    <h4>Manage Questions</h4>
                    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addQuestionModal">Add
                        New Question</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="questionTable">
                            <?php foreach ($questions as $question) { ?>
                                <tr>
                                    <td><?php echo $question['id']; ?></td>
                                    <td><?php echo $question['question']; ?></td>
                                    <td><button class="btn btn-danger">Delete</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Manage Lessons Tab -->
                <div class="tab-pane fade" id="lessons" role="tabpanel" aria-labelledby="lessons-tab">
                    <h4>Manage Lessons</h4>
                    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addLessonModal">Add New
                        Lesson</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lesson Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="lessonTable">
                            <?php foreach ($lessons as $lesson) { ?>
                                <tr>
                                    <td><?php echo $lesson['id']; ?></td>
                                    <td><?php echo $lesson['title']; ?></td>
                                    <td><button class="btn btn-danger">Delete</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- View Students Tab -->
                <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                    <h4>Registered Students</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Year Level</th>
                                <th>Section</th>
                            </tr>
                        </thead>
                        <tbody id="studentTable">
                            <?php foreach ($students as $student) { ?>
                                <tr>
                                    <td><?php echo $student['id']; ?></td>
                                    <td><?php echo $student['name']; ?></td>
                                    <td><?php echo $student['year_level']; ?></td>
                                    <td><?php echo $student['section']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Analytics Tab -->
                <div class="tab-pane fade" id="analytics" role="tabpanel" aria-labelledby="analytics-tab">
                    <h4>Student Registration Analytics</h4>
                    <canvas id="analyticsChart" width="400" height="200"></canvas>
                    <script>
                        const ctx = document.getElementById('analyticsChart').getContext('2d');
                        const analyticsChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(<?php echo json_encode($analytics_data); ?>),
                                datasets: [{
                                    label: 'Number of Students',
                                    data: Object.values(<?php echo json_encode($analytics_data); ?>).map(section => Object.values(section).reduce((a, b) => a + b, 0)),
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Question Modal -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">Add New Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <div class="mb-3">
                            <label for="answer" class="form-label">Answer</label>
                            <input type="text" class="form-control" id="answer" name="answer" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_question">Add Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Lesson Modal -->
    <div class="modal fade" id="addLessonModal" tabindex="-1" aria-labelledby="addLessonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLessonModalLabel">Add New Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="lessonTitle" class="form-label">Lesson Title</label>
                            <input type="text" class="form-control" id="lessonTitle" name="lesson_title" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="add_lesson">Add Lesson</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>