// addQuestion.php
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'coderift');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

$question = $_POST['question'];
$answer = $_POST['answer'];

$sql = "INSERT INTO questions (question, answer) VALUES ('$question', '$answer')";
if (mysqli_query($conn, $sql)) {
    echo "New question added successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
<script>
    // Fetch questions from the backend
    fetch('getQuestions.php')
        .then(response => response.json())
        .then(data => {
            populateTable(data, 'questionTable');
        });

    // Handle Add Question Form Submission
    document.getElementById('addQuestionForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let question = document.getElementById('question').value;
        let answer = document.getElementById('answer').value;

        fetch('addQuestion.php', {
            method: 'POST',
            body: new URLSearchParams({
                'question': question,
                'answer': answer
            })
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();  // Reload the page to display the updated data
            });
    });

</script>