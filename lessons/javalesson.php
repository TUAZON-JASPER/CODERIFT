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
    <title>Lesson Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: url('./img/MENU.svg') no-repeat center center;
            background-size: cover;
            position: relative;
        }

        .backbtn {
            height: 40px;
        }

        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .title {
            font-size: 25px;
        }

        .module {
            padding: 20px 0 0 0;
            background-color: white;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .module-title {
            font-size: 24px;
            text-align: center;
            margin-bottom: 10px;
        }

        .module-description {
            font-size: 16px;
            text-align: center;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .lesson-list {
            list-style: none;
            padding: 0px;
        }

        .lesson-list li {
            font-size: 18px;
            text-align: center;
            padding: 30px 0;
            border-bottom: 1px solid #e9ecef;
            cursor: grab;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .lesson-list li:hover {
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }


        .lesson-list li:last-child {
            border-bottom: none;
        }

        .clogo {
            width: 130px;
            height: 130px;
            animation: pulse 2s linear infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        audio {
            max-width: 100%;
        }

        .bg {
            background-color: #2e0606;
        }

        #back {
            margin: 10px;
            color: white;
        }

        #javaCompilerOutput {
            font-family: 'Courier New', monospace;
            /* Monospace font for command prompt look */
            background-color: #1e1e1e;
            /* Dark background similar to command prompt */
            color: #00ff00;
            /* Green text color */
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
            /* Preserve whitespace formatting */
            word-wrap: break-word;
            /* Ensure long lines wrap properly */
            max-height: 300px;
            /* Set a max height */
            overflow-y: auto;
            /* Enable scrolling if content exceeds max height */
        }
    </style>
</head>

<body>
    <section class="navbar text-light border-body border-bottom p-5" style="background-color: #723030;">
        <div class="back"><a href="../lessons.php"><img class="backbtn" src="../img/back2.png" alt="backbutton"></a>
        </div>
        <div class="header">
            <img class="clogo" src="../img/java.png">
            <h1>Java Lessons</h1>
        </div>
        <div id="point"></div>
    </section>

    <div class="container mt-4">
        <div class="module col-8">
            <h2 class="module-title">Java Basics</h2>
            <p class="module-description">Learn the fundamentals of Java</p>
            <ul class="lesson-list">
                <li data-toggle="modal" data-target="#lesson1Modal">Lesson 1: <br><span
                        style="font-size: 22px;">Elements of Java</span></li>
                <li data-toggle="modal" data-target="#lesson2Modal">Lesson 2: <br><span
                        style="font-size: 22px;">Programming Basics</span></li>
                <li data-toggle="modal" data-target="#lesson3Modal">Lesson 3: <br><span
                        style="font-size: 22px;">Selection</span></li>
                <li data-toggle="modal" data-target="#lesson4Modal">Lesson 4: <br><span
                        style="font-size: 22px;">Loops</span></li>
                <li data-toggle="modal" data-target="#lesson5Modal">Lesson 5: <br><span
                        style="font-size: 22px;">Designing Methods</span></li>
                <li data-toggle="modal" data-target="#lesson6Modal">Lesson 6: <br><span style="font-size: 22px;">Static
                        Methods & Fields</span></li>
                <li data-toggle="modal" data-target="#lesson7Modal">Lesson 7: <br><span style="font-size: 22px;">Method
                        Overloading</span></li>
                <li data-toggle="modal" data-target="#lesson8Modal">Lesson 8: <br><span
                        style="font-size: 22px;">Constructors</span></li>
                <li data-toggle="modal" data-target="#lesson9Modal">Lesson 9: <br><span
                        style="font-size: 22px;">Encapsulation</span></li>
                <li data-toggle="modal" data-target="#lesson10Modal">Lesson 10: <br><span
                        style="font-size: 22px;">Inheritance</span></li>
                <li data-toggle="modal" data-target="#lesson10Modal">Lesson 11: <br><span
                        style="font-size: 22px;">Abstract Classes</span></li>
            </ul>
        </div>
        <div class="compiler col-4 mt-4" style="position: fixed; right: 2%; top: 38%;">
            <!-- Java Code Editor -->
            <div class="form-group mt-3">
                <label for="javaCodeInput"><strong>Write Java Code:</strong></label>
                <textarea id="javaCodeInput" class="form-control" rows="6"
                    placeholder="Write your Java code here..."></textarea>
            </div>
            <button class="btn btn-primary mt-3" id="compileJavaCodeBtn">Compile and Run</button>

            <h4 class="mt-4">Output:</h4>
            <pre id="javaCompilerOutput" style="display: none;"></pre> <!-- Initially hidden -->

            <!-- This will now have the command prompt style -->
        </div>
    </div>

    <!-- Modals -->
    <!-- Lesson 1 Modal -->
    <div class="modal fade" id="lesson1Modal" tabindex="-1" aria-labelledby="lesson1ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson1ModalLabel">Lesson 1: Elements of Java</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>The core structure of a Java program begins with the main method,
                        which is the entry point where the program starts execution.
                        It is mandatory in every Java application, and its signature looks like this:

                        public static void main(String[] args) { <br>
                        // Code to execute <br>
                        } <br>
                        The public keyword makes the method accessible from anywhere, static means it
                        belongs to the class rather than an instance, void means it returns nothing, and String[] args
                        allows command-line arguments to be passed into the program. Java source files have the .java
                        extension, and they are compiled into .class files,
                        which contain the bytecode executed by the Java Virtual Machine (JVM). <br>
                    </p>
                    <p>
                        <strong>Example: </strong><br>
                    <ul>
                        <pre><code>
public class HelloWorld {
    public static void main(String[] args) {
        System.out.println("Hello, World!");
    }
}
                            </code></pre>
                    </ul>
                    This simple example prints "Hello, World!" to the console.
                    </p>
                    <audio controls>
                        <source src="path/to/audio/file1.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 2 Modal -->
    <div class="modal fade" id="lesson2Modal" tabindex="-1" aria-labelledby="lesson2ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson2ModalLabel">Lesson 2: Programming Basics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>In Java, data is stored in variables, which are containers for data values.
                        Java offers primitive data types such as int, char, boolean, and float. Non-primitive
                        types include objects like String. Unlike primitive types,
                        String is a reference type, even though it can be used similarly to primitives.</p>
                    <p>
                        <strong>Example of primitive and reference types:</strong> <br>
                        <br>
                        <br>
                        In this example, int is a primitive type, while String is an object that holds a sequence of
                        characters.
                    </p>
                    <audio controls>
                        <source src="path/to/audio/file2.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 3 Modal -->
    <div class="modal fade" id="lesson3Modal" tabindex="-1" aria-labelledby="lesson3ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson3ModalLabel">Lesson 3: Selection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>In this example, int is a primitive type, while String is an object that
                        holds a sequence of characters.</p>
                    <p><strong>Example of switch-case: </strong></p>
                    <p>Here, the switch statement checks the value of the variable day and executes the matching case.
                    </p>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson4Modal" tabindex="-1" aria-labelledby="lesson4ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson4ModalLabel">Lesson 4: Loops</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Loops are used for repeated execution of code. In Java, the for,
                        while, and do-while loops are common. The do-while loop is unique because it checks the
                        condition at the <strong>end</strong> of the loop, guaranteeing that the loop body runs at least
                        once.</p>
                    <p><strong>Example of a do-while loop:</strong></p><br>
                    <p>This loop will print the numbers 0 to 4, incrementing i after each iteration.</p>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson5Modal" tabindex="-1" aria-labelledby="lesson5ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson5ModalLabel">Lesson 5: Designing Methods</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A method in Java is a block of code that performs a specific task. Methods can take parameters,
                        process the data, and return a result.
                        Methods are a fundamental part of making programs modular and reusable.</p> <br>
                    <p><strong>Example of method:</strong></p><br>
                    <br>
                    <br>
                    <p>Here, the addNumbers method takes two integers as parameters and returns their sum.</p>
                    <p><strong>Calling the method: </strong></p><br>
                    <br>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson6Modal" tabindex="-1" aria-labelledby="lesson6ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson6ModalLabel">Lesson 6: Static Methods & Fields</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A static method or field belongs to the class, rather than to instances of the class.
                        This means that static members can be accessed without creating an object of the class.
                        The keyword static is used to define these members.</p><br>
                    <p><strong>Example of static fields and methods: </strong></p> <br>
                    <br>
                    <br>
                    <p>In this example, the static field count and the static method incrementCount are shared
                        among all instances of the Counter class.</p>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson7Modal" tabindex="-1" aria-labelledby="lesson7ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson7ModalLabel">Lesson 7: Method Overloading</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Method overloading allows multiple methods in a class to have the same name but different
                        parameter lists.
                        This enables the same method name to be used for different types of inputs or numbers of
                        parameters.</p><br>
                    <p><strong>Example of method overloading: </strong></p> <br>
                    <br>
                    <br>
                    <p>Here, the add method is overloaded with two versions: one for integers and one for doubles.</p>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson8Modal" tabindex="-1" aria-labelledby="lesson8ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson8ModalLabel">Lesson 8: Constructors</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>A constructor in Java is used to initialize an object when it is created. It has
                        the same name as the class and does not have a return type. Constructors
                        are called automatically when an object is created.</p><br>
                    <p><strong>Example of method overloading: </strong></p> <br>
                    <br>
                    <br>
                    <p></p>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson9Modal" tabindex="-1" aria-labelledby="lesson9ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson9ModalLabel">Lesson 9: Encapsulation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Encapsulation is the principle of wrapping data (fields) and code (methods) together
                        in a class and restricting access to them from outside the class. This is typically achieved
                        using access
                        modifiers such as private for fields and providing public getter and setter methods to interact
                        with the data.</p><br>
                    <p><strong>Example of encapsulation: </strong></p> <br>
                    <br>
                    <br>
                    <p>In this example, the name field is private, meaning it cannot be accessed directly from outside
                        the class.
                        Instead, it is accessed through the getName and setName methods.</p><br>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson10Modal" tabindex="-1" aria-labelledby="lesson10ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson10ModalLabel">Lesson 10: Inheritance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Inheritance allows a class to inherit fields and methods from another class.
                        In Java, the extends keyword is used to create a subclass from a superclass.</p><br>
                    <p><strong>Example of inheritance: </strong></p> <br>
                    <br>
                    <br>
                    <p>In this example, the Dog class inherits the eat method from the Animal class, and it also defines
                        its own bark method.</p><br>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lesson11Modal" tabindex="-1" aria-labelledby="lesson11ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson11ModalLabel">Lesson 11: Abstract Classes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>An abstract class in Java is a class that cannot be instantiated on
                        its own and is meant to be a base class for other classes. Abstract classes can
                        have abstract methods, which are methods without an implementation.
                        Subclasses of the abstract class must provide implementations for these abstract methods.</p>
                    <br>
                    <p><strong>Example of inheritance: </strong></p> <br>
                    <br>
                    <br>
                    <p>Here, the Animal class is abstract, and the Cat class provides an implementation for the
                        makeSound method.</p><br>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('compileJavaCodeBtn').addEventListener('click', function () {
            var javaCode = document.getElementById('javaCodeInput').value;

            // Hide the output area initially when starting compilation
            document.getElementById('javaCompilerOutput').style.display = 'none';

            // Send the Java code to compile_java.php via AJAX
            fetch('compile_java.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'javaCode=' + encodeURIComponent(javaCode)
            })
                .then(response => response.json())  // Parse the response as JSON
                .then(data => {
                    console.log(data);  // Log the response for troubleshooting

                    if (data.status === 'success') {
                        // Display the output when compilation is successful
                        document.getElementById('javaCompilerOutput').textContent = data.output;
                    } else {
                        // Display an error message if there was a problem with compilation
                        document.getElementById('javaCompilerOutput').textContent = data.message;
                    }

                    // Show the output area after compilation
                    document.getElementById('javaCompilerOutput').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);  // Log any error to the console
                    document.getElementById('javaCompilerOutput').textContent = "An error occurred during the compilation process.";
                    document.getElementById('javaCompilerOutput').style.display = 'block';
                });
        });
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>