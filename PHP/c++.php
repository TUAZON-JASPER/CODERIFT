<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/font.css">
    <link rel="stylesheet" href="../css/body.css">
    <link rel="stylesheet" href="../css/difficulties.css">
    <title>Code Rift</title>
    <style>
        body {
            background: url('../img/bg.png');
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <section class="header">
        <div class="back"><a href="../start.php"><img class="backbtn" src="../img/back.png" alt="backbutton"></a></div>
        <div class="title">Choose a Difficulty</div>
        <div id="point"></div>
    </section>
    <hr>

    <section class="difficulties">
        <a href="/HTML/cpp/cppEASY/ceasy.html" onclick="handleClick(event, '../quiz/cppEASY/ceasy.php')">
            <div id="cover" class="cpp">EASY</div>
            <div id="ceasy" >
                <div class="definition">
                    <div class="title"><strong>Click the correct answer</strong></div>
                    <div class="tutorial">A question will appear with several answer options. Click on the right one to earn a point.</div>
                </div>
                <div class="sample">
                    <div class="question"></div>
                    <div class="choices">
                        <div class="right">right</div>
                        <div class="wrong">wrong</div>
                    </div>
                </div>
            </div>
        </a>
        
        <a  href="/HTML/cpp/cppINTERMEDIATE/cintermediate.html" onclick="handleClick(event, '../quiz/cppINTERMEDIATE/cintermediate.php')">
            <div id="cover" class="cpp">INTERMEDIATE</div>
            <div class="cinter" id="difficulty">
                <div class="definition">
                    <div class="title"><strong>Fill in the blank with the correct choice.</strong></div>
                    <div class="tutorial">A sentence with a blank space will appear. Pick the correct answer from the given choices and place it in the blank. If it’s correct, you gain a point.</div>
                </div>
                <div class="sample2">
                    <div class="instruction">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed.</div>
                    <div class="question2">
                        <p>Lorem <span>.</span> dolor sit amet</p>
                    </div>
                    <div class="choices2">
                        <div class="right2">ipsum</div>
                        <div class="wrong2">check</div>
                    </div>
                </div>
            </div>
        </a>
        <a href="/HTML/cpp/cppADVANCE/cadvance.html" onclick="handleClick(event, '../quiz/cppADVANCE/cadvance.php')">
            <div id="cover" class="cpp">ADVANCE</div>
            <div class="cadvance" id="difficulty">
                <div class="definition">
                    <div class="title"><strong>Show the correct output.</strong></div>
                    <div class="tutorial">You will be given an instruction or problem. Provide the correct output based on the instructions to earn a point.</div>
                </div>
                <div class="sample3">
                    <div class="question3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</div>
                    <div class="textbox"></div>
                    <div class="submit">submit</div>
                </div>
            </div>
        </a>
    </section>

    <audio id="bgmusic" loop>
        <source src="../audio/quizmusic.mp3" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>
    <script src="../script/audio.js"></script>
    <script src="../script/click.js"></script>
    <script src="../script/questions.js"></script>
</body>
</html>