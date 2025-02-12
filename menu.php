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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/menu.css">
    <link rel="stylesheet" href="./css/body.css">
    <link rel="stylesheet" href="./css/font.css">
    <link rel="icon" href="./img/CR.png">
    <title>Code Rift</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background: url('./img/menu.svg') no-repeat center center;
            background-size: cover;
            position: relative;
            overflow: hidden;
        }


        .symbol {
            font-size: 50px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            /* Make sure it's behind the content */
        }

        .logo,
        .buttons {
            z-index: 1;
            /* Keep the logo and buttons above the symbols */
        }
    </style>

<body>
    <div class="container text-center mt-5">
        <div class="logo mb-4">
            <img class="crlogo img-fluid" src="./img/CR.png" alt="CodeRiftlogo">
        </div>
        <section class="buttons mb-4">
            <a class="btn btn-secondary mx-2" href="start.php">Start</a>
            <a class="btn btn-secondary mx-2" href="lessons.php">Lessons</a>
            <a class="btn btn-secondary mx-2" href="settings.php">Settings</a>
        </section>
    </div>

    <!-- Three bouncing symbols -->
    <div class="symbol" id="symbol1">{</div>
    <div class="symbol" id="symbol2">[</div>
    <div class=" symbol" id="symbol3">(</div>
    <div class=" symbol" id="symbol4">/</div>

    <script>
        const symbols = ['{', '}', '[', ']', '<', '>', '(', ')', '+', '=', '-', '_', '?', '"', "'"];

        function changeSymbol(symbolElement) {
            let currentIndex = Math.floor(Math.random() * symbols.length);
            symbolElement.textContent = symbols[currentIndex];
        }

        // Common function to handle bouncing logic
        function createBouncingSymbol(symbolElement, dx, dy, symbolSize, bounceSpeed) {
            let x = Math.random() * window.innerWidth;
            let y = Math.random() * window.innerHeight;

            function bounceEffect() {
                symbolElement.style.transition = `transform ${bounceSpeed}s ease`;
                symbolElement.style.transform = "scale(1.5)";
                setTimeout(() => {
                    symbolElement.style.transform = "scale(1)";
                }, bounceSpeed * 1000);
            }

            function moveSymbol() {
                x += dx;
                y += dy;

                // Check collision with sides and apply bounce effect, then change symbol
                if (x <= symbolSize / 2) {
                    x = symbolSize / 2;
                    dx *= -1; // Reverse direction
                    bounceEffect();
                    changeSymbol(symbolElement); // Change symbol on collision
                } else if (x >= window.innerWidth - symbolSize / 2) {
                    x = window.innerWidth - symbolSize / 2;
                    dx *= -1;
                    bounceEffect();
                    changeSymbol(symbolElement);
                }

                if (y <= symbolSize / 2) {
                    y = symbolSize / 2;
                    dy *= -1;
                    bounceEffect();
                    changeSymbol(symbolElement);
                } else if (y >= window.innerHeight - symbolSize / 2) {
                    y = window.innerHeight - symbolSize / 2;
                    dy *= -1;
                    bounceEffect();
                    changeSymbol(symbolElement);
                }

                // Update symbol position
                symbolElement.style.left = `${x}px`;
                symbolElement.style.top = `${y}px`;

                requestAnimationFrame(moveSymbol);
            }

            // Initialize symbol position
            symbolElement.style.position = "absolute";
            symbolElement.style.left = `${x}px`;
            symbolElement.style.top = `${y}px`;

            // Start the movement
            moveSymbol();
        }

        // Create three different bouncing symbols with different behaviors
        createBouncingSymbol(document.getElementById('symbol1'), 3, 2, 50, 0.2);  // Fast bounce
        createBouncingSymbol(document.getElementById('symbol2'), -2, 4, 50, 0.4); // Slower bounce
        createBouncingSymbol(document.getElementById('symbol3'), 1, 3, 50, 0.3);  // Moderate bounce
        createBouncingSymbol(document.getElementById('symbol4'), 4, 5, 50, 0.5);  // Moderate bounce

    </script>
</body>



</html>