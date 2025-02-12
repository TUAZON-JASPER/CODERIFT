// addLesson.php
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

$title = $_POST['lessonTitle'];

$sql = "INSERT INTO lessons (title) VALUES ('$title')";
if (mysqli_query($conn, $sql)) {
    echo "New lesson added successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<script>
    // Fetch lessons from the backend
    fetch('getLessons.php')
        .then(response => response.json())
        .then(data => {
            populateTable(data, 'lessonTable');
        });

    // Handle Add Lesson Form Submission
    document.getElementById('addLessonForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let lessonTitle = document.getElementById('lessonTitle').value;

        fetch('addLesson.php', {
            method: 'POST',
            body: new URLSearchParams({
                'lessonTitle': lessonTitle
            })
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();  // Reload the page to display the updated data
            });
    });

</script>