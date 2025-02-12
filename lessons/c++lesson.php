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
            width: 100px;
            height: 100px;
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
            background: #098d40;
        }

        #back {
            margin: 10px;
        }

        #compilerOutput {
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
            max-height: 500px;
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
            <img class="clogo" src="../img/c++.png">
            <h1>C++ Lessons</h1>
        </div>
        <div id="point"></div>
    </section>

    <div class="container mt-4 d-flex p-2">
        <div class="module col-8">
            <h2 class="module-title">C++ Basics</h2>
            <p class="module-description">Learn the fundamentals of C++</p>
            <ul class="lesson-list">
                <li data-toggle="modal" data-target="#lesson1Modal">Lesson 1: <br><span
                        style="font-size: 22px;">Introduction to C++</span></li>
                <li data-toggle="modal" data-target="#lesson2Modal">Lesson 2: <br><span style="font-size: 22px;">Basic
                        Input/Output</span></li>
                <li data-toggle="modal" data-target="#lesson3Modal">Lesson 3: <br><span
                        style="font-size: 22px;">Variables in C++</span></li>
                <li data-toggle="modal" data-target="#lesson4Modal">Lesson 4: <br><span style="font-size: 22px;">Data
                        Types</span></li>
                <li data-toggle="modal" data-target="#lesson5Modal">Lesson 5: <br><span
                        style="font-size: 22px;">Operators</span></li>
                <li data-toggle="modal" data-target="#lesson6Modal">Lesson 6: <br><span
                        style="font-size: 22px;">Decision-Making Statements</span></li>
                <li data-toggle="modal" data-target="#lesson7Modal">Lesson 7: <br><span style="font-size: 22px;">Loop
                        Types</span></li>
                <li data-toggle="modal" data-target="#lesson8Modal">Lesson 8: <br><span
                        style="font-size: 22px;">Functions</span></li>
                <li data-toggle="modal" data-target="#lesson9Modal">Lesson 9: <br><span
                        style="font-size: 22px;">Arrays</span></li>
                <li data-toggle="modal" data-target="#lesson10Modal">Lesson 10: <br><span
                        style="font-size: 22px;">Strings</span></li>
                <li data-toggle="modal" data-target="#lesson11Modal">Lesson 11: <br><span
                        style="font-size: 22px;">Pointers</span></li>
            </ul>
        </div>
        <div class="compiler col-4 mt-4" style="position: fixed; right: 2%; top: 38%;">
            <!-- C++ Code Editor -->
            <div class="form-group mt-3">
                <label for="cppCodeInput"><strong>Write C++ Code:</strong></label>
                <textarea id="cppCodeInput" class="form-control" rows="6"
                    placeholder="Write your C++ code here..."></textarea>
            </div>
            <button class="btn btn-primary mt-3" id="compileCodeBtn">Compile and Run</button>

            <h4 class="mt-4">Output:</h4>
            <pre id="compilerOutput" style="display: none;"></pre> <!-- Initially hidden -->
            <!-- This will now have the command prompt style -->
        </div>
    </div>

    <!-- Modals -->
    <!-- Lesson 1 Modal -->
    <div class="modal fade" id="lesson1Modal" tabindex="-1" aria-labelledby="lesson1ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson1ModalLabel">Lesson 1: Introduction to C++</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>C++ is a powerful, high-performance programming language that supports multiple
                        programming paradigms, including procedural, object-oriented, and generic programming.
                        It was created by Bjarne Stroustrup in the early 1980s as an enhancement to the C language. C++
                        is widely used for system/software development, game programming, and applications requiring
                        real-time performance.
                    </p>
                    <ul style="list-style: none;">
                        <li><strong>Key Features: </strong>
                            <ul>
                                <li>Compiled language for faster execution.</li>
                                <li>Strongly typed with a rich set of data types.</li>
                                <li>Support for low-level memory manipulation.</li>
                                <li>Extensive standard library.</li>
                            </ul>
                        </li>
                        <li><strong>File Extension: </strong> The standard file extension for C++ source code is
                            <strong>.cpp.</strong>
                        </li>
                    </ul>
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
                    <h5 class="modal-title" id="lesson2ModalLabel">Lesson 2: Basic Input/Output</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>C++ provides robust facilities for input and output operations primarily through the
                        <strong>iostream</strong> library. The two main objects used for I/O are cin (console input) and
                        cout (console output).
                    </p>
                    <ul style="list-style: none;">
                        <li><strong>Output Keyword: </strong>The keyword used for output in C++ is <strong>
                                cout.</strong></li>
                        <li><strong>Example:</strong></li>
                        <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    string name;
    cout << "Enter your name: ";
    cin >> name;
    cout << "Hello, " << name << "!" << endl;
    return 0;
}

                    </code></pre>
                    </ul>
                    <audio controls>
                        <source src="../audio/c2.mp3" type="audio/mpeg">
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
                    <h5 class="modal-title" id="lesson3ModalLabel">Lesson 3: Variables in C++</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Variables are used to store data in a program. Each variable must be declared with a
                        specific data type before it can be used, indicating what kind of data it can hold.</p>
                    <ul style="list-style: none;">
                        <li><strong>Correct Declaration: </strong>The correct way to declare an integer variable is
                            <strong> int x;.</strong>
                        </li>
                        <li><strong>Example:</strong><br>
                            <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    // Variable declarations
    int age = 25;          // Integer variable to store age
    double height = 5.9;   // Double variable to store height
    char grade = 'A';      // Char variable to store grade
    bool isStudent = true; // Boolean variable to store if the person is a student

    // Output the values of the variables
    cout << "Age: " << age << endl;
    cout << "Height: " << height << endl;
    cout << "Grade: " << grade << endl;
    cout << "Is Student: " << isStudent << endl;

    return 0;
}

                        </code></pre>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 4 Modal -->
    <div class="modal fade" id="lesson4Modal" tabindex="-1" aria-labelledby="lesson4ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson4ModalLabel">Lesson 4: Data Types</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>C++ supports various data types that define the type
                        of data a variable can hold. Common data types include:</p>
                    <ul>
                        <li><strong>int: </strong>Whole numbers (e.g., int score = 100;)</li>
                        <li><strong>float: </strong>Floating-point numbers (e.g., float temperature = 36.6;)</li>
                        <li><strong>double: </strong>Larger floating-point numbers (e.g., double pi = 3.14159;)</li>
                        <li><strong>char: </strong>Single characters (e.g., char letter = 'Z';)</li>
                        <li><strong>bool: </strong>Boolean values (true/false).</li>
                    </ul>
                    <li style="list-style: none;"><strong>Floating-Point Keyword: </strong>The keyword used to declare a
                        floating-point variable is <strong>float.</strong></li>
                    <li style="list-style: none;"><strong>Example: </strong>
                        <br>
                        <ul>
                            <pre><code>
#include &lt;iostream&gt;
using namespace std;
    
int main() {
    int age = 30;               // Integer data type
    float temperature = 36.6;    // Floating-point data type
    double pi = 3.14159;         // Double data type for higher precision
    char grade = 'A';            // Character data type
    bool isPassed = true;        // Boolean data type
    string name = "Alice";       // String data type
    
    cout << "Name: " << name << endl;
    cout << "Age: " << age << endl;
    cout << "Temperature: " << temperature << endl;
    cout << "Pi: " << pi << endl;
    cout << "Grade: " << grade << endl;
    cout << "Passed: " << (isPassed ? "Yes" : "No") << endl;
    
    return 0;
}
    
                            </code></pre>
                        </ul>
                    </li>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 5 Modal -->
    <div class="modal fade" id="lesson5Modal" tabindex="-1" aria-labelledby="lesson5ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson5ModalLabel">Lesson 5: Operators</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Operators in C++ are symbols used to perform operations on variables and values.
                        Types of Operators</p>

                    <br><strong>Arithmetic Operators:</strong> Perform basic math operations.
                    <br>Example: +, -, *, /, %<br>
                    <br><strong>Relational Operators:</strong> Compare values.
                    <br>Example: ==, !=, >, <,>=, <=<br>
                            <br><strong>Logical Operators:</strong> Combine conditions.
                            <br>Example: &&, ||, !<br>
                            <br><strong>Assignment Operators:</strong> Assign values to variables.
                            <br>Example: =, +=, -=, *=, /=, %=<br>
                            <br><strong>Increment/Decrement Operators:</strong> Increase or decrease variable values by
                            one.
                            <br>Example: ++, --<br>
                            <br><strong>Bitwise Operators:</strong> Perform operations on binary numbers.
                            <br>Example: &, |, ^, <<,>><br>
                                <br><strong>Ternary Operator:</strong> Conditional operator.
                                <br>Example: condition ? value_if_true : value_if_false<br>
                                <br><strong>Example: </strong>
                                <ul>
                                    <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int a = 10, b = 5;

    // Arithmetic operators
    int sum = a + b;          // Addition
    int difference = a - b;   // Subtraction
    int product = a * b;      // Multiplication
    int quotient = a / b;     // Division
    int remainder = a % b;    // Modulus (remainder)

    // Relational operators
    bool isEqual = (a == b);  // Equality check
    bool isGreater = (a > b); // Greater than check

    // Logical operators
    bool andResult = (a > b) && (b < 10);  // Logical AND
    bool orResult = (a > b) || (b > 10);   // Logical OR

    // Output results
    cout &lt;&lt; "Sum: " &lt;&lt; sum &lt;&lt; endl;
    cout &lt;&lt; "Difference: " &lt;&lt; difference &lt;&lt; endl;
    cout &lt;&lt; "Product: " &lt;&lt; product &lt;&lt; endl;
    cout &lt;&lt; "Quotient: " &lt;&lt; quotient &lt;&lt; endl;
    cout &lt;&lt; "Remainder: " &lt;&lt; remainder &lt;&lt; endl;
    cout &lt;&lt; "Is Equal: " &lt;&lt; isEqual &lt;&lt; endl;
    cout &lt;&lt; "Is Greater: " &lt;&lt; isGreater &lt;&lt; endl;
    cout &lt;&lt; "Logical AND Result: " &lt;&lt; andResult &lt;&lt; endl;
    cout &lt;&lt; "Logical OR Result: " &lt;&lt; orResult &lt;&lt; endl;

    return 0;
}
    </code></pre>
                                </ul>
                                <li style="list-style: none;"><strong>Usage:</strong> Operators are essential for
                                    calculations, comparisons, and logical operations in C++.
                                    They manipulate variables and control program flow efficiently.</li>
                                <audio controls>
                                    <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 6 Modal -->
    <div class="modal fade" id="lesson6Modal" tabindex="-1" aria-labelledby="lesson6ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson6ModalLabel">Lesson 6: Decision-Making Statements</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>C++ provides various control structures for decision-making, such as if, else if, else,
                        and switch. These allow you to execute different blocks of code based on certain conditions.</p>
                    <ul>
                        <li style="list-style: none;"><strong>Switch Statement: </strong>The keyword used to handle
                            multiple cases in a
                            switch is <strong> case.</strong></li>
                        <li style="list-style: none;"><strong>Example: </strong><br>
                            <ul>
                                <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int age;
    cout << "Enter your age: ";
    cin >> age;

    if (age >= 18) {
        cout << "You are an adult." << endl;
    }
    else if (age >= 13) {
        cout << "You are a teenager." << endl;
    }
    else {
        cout << "You are a child." << endl;
    }

    return 0;
}

                            </code></pre>
                            </ul>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 7 Modal -->
    <div class="modal fade" id="lesson7Modal" tabindex="-1" aria-labelledby="lesson7ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson7ModalLabel">Lesson 7: Loop Types</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Loops are used to execute a block of code multiple times. C++ supports several types of loops:
                    </p>
                    <ul>
                        <li><strong>for Loop: </strong>Typically used when the number of iterations is known.</li>
                        <li><strong>while Loop: </strong>Used when the number of iterations is not predetermined.</li>
                        <li><strong>do-while Loop</strong>Similar to the while loop, but guarantees at least one
                            execution.</li>
                    </ul>
                    <ul style="list-style: none;">
                        <li><strong>Common Loop: </strong>The loop typically used when the number of iterations is known
                            is the <strong> for </strong>loop.</li>
                        <li><strong>Example:</strong><br>
                            <ul>
                                <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    // For loop
    cout << "For loop:" << endl;
    for (int i = 1; i <= 5; i++) {
        cout << "Iteration " << i << endl;
    }

    // While loop
    cout << "\nWhile loop:" << endl;
    int j = 1;
    while (j <= 5) {
        cout << "Iteration " << j << endl;
        j++;
    }

    // Do-While loop
    cout << "\nDo-While loop:" << endl;
    int k = 1;
    do {
        cout << "Iteration " << k << endl;
        k++;
    } while (k <= 5);

    return 0;
}

                        </code></pre>
                            </ul>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 8 Modal -->
    <div class="modal fade" id="lesson8Modal" tabindex="-1" aria-labelledby="lesson8ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson8ModalLabel">Lesson 8: Functions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Functions in C++ are blocks of code designed to perform a specific task.
                        They help in organizing code and promoting reusability.</p>

                    <ul>
                        <li style="list-style: none;"><strong>Passing Values: </strong>Values are passed to functions
                            using<strong> Parameters.</strong></li>
                        <li style="list-style: none;"><strong>Example: </strong><br>
                            <ul>
                                <pre><code>
#include &lt;iostream&gt;
using namespace std;

// Function declaration
void greet(string name);
int add(int a, int b);

int main() {
    // Function calls
    greet("John");  // Calling greet function
    int sum = add(5, 3);  // Calling add function and storing the result
    cout << "Sum: " << sum << endl;  // Displaying the sum

    return 0;
}

// Function definition for greet
void greet(string name) {
    cout << "Hello, " << name << "!" << endl;
}

// Function definition for add
int add(int a, int b) {
    return a + b;
}

                        </code></pre>
                            </ul>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 9 Modal -->
    <div class="modal fade" id="lesson9Modal" tabindex="-1" aria-labelledby="lesson9ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson9ModalLabel">Lesson 9: Arrays</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Arrays are collections of items of the same type, allowing you to store multiple values in a
                        single variable.</p>
                    <ul>
                        <li style="list-style: none;"><strong>Last Element Index: </strong>The index of the last element
                            in a 5-element array is<strong> 4.</strong></li>
                        <li style="list-style: none;"><strong>Example: </strong><br>
                            <ul>
                                <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    // Declare an array of 5 integers
    int numbers[5] = {10, 20, 30, 40, 50};

    // Print the elements of the array
    cout << "Array elements are: " << endl;
    for (int i = 0; i < 5; i++) {
        cout << numbers[i] << " ";
    }
    cout << endl;

    return 0;
}

                        </code></pre>
                            </ul>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 10 Modal -->
    <div class="modal fade" id="lesson10Modal" tabindex="-1" aria-labelledby="lesson10ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson10ModalLabel">Lesson 10: Strings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Strings in C++ are used to handle text and are part of the standard library.
                        The string class provides various functions to manipulate strings.</p>

                    <ul>
                        <li style="list-style: none;"><strong>String Length Function: </strong>The function that returns
                            the length of a string is <strong>length().</strong></li>
                        <li style="list-style: none;"><strong>Example: </strong><br>
                            <ul>
                                <pre><code>
#include &lt;iostream&gt;
#include <string>  // Required to use string class
using namespace std;

int main() {
    string firstName = "John";    // Declare and initialize a string variable
    string lastName = "Doe";      // Another string variable
    string fullName = firstName + " " + lastName;  // Concatenate strings

    cout << "Full Name: " << fullName << endl;

    // String manipulation
    cout << "First letter of the first name: " << firstName[0] << endl;
    cout << "Length of last name: " << lastName.length() << endl;

    return 0;
}

                        </code></pre>
                            </ul>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson 11 Modal -->
    <div class="modal fade" id="lesson11Modal" tabindex="-1" aria-labelledby="lesson11ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lesson11ModalLabel">Lesson 11: Pointers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Pointers are variables that store the memory address of another variable.
                        They are powerful features of C++ that enable direct memory management.</p>

                    <ul>
                        <li style="list-style: none;"><strong>Null Pointer Value: </strong>The value typically assigned
                            to a pointer that does not point to anything is <strong>nullptr.</strong></li>
                        <li style="list-style: none;"><strong>Example: </strong><br>
                            <ul>
                                <pre><code>
#include &lt;iostream&gt;
using namespace std;

int main() {
    int num = 10;           // Declare an integer variable
    int *ptr = &num;        // Declare a pointer and store the address of 'num'

    cout << "Value of num: " << num << endl;          // Output the value of 'num'
    cout << "Address of num: " << &num << endl;       // Output the address of 'num'
    cout << "Value of ptr: " << ptr << endl;          // Output the value of the pointer (address of 'num')
    cout << "Value pointed to by ptr: " << *ptr << endl;  // Output the value at the address stored in the pointer

    return 0;
}

                        </code></pre>
                            </ul>
                        </li>
                    </ul>
                    <audio controls>
                        <source src="path/to/audio/file3.mp3" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('compileCodeBtn').addEventListener('click', function () {
            var cppCode = document.getElementById('cppCodeInput').value;

            // Hide the output area initially when starting compilation
            document.getElementById('compilerOutput').style.display = 'none';

            // Send the C++ code to compile.php via AJAX
            fetch('compile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'cppCode=' + encodeURIComponent(cppCode)
            })
                .then(response => response.json())  // Parse the response as JSON
                .then(data => {
                    console.log(data);  // Log the response for troubleshooting

                    if (data.status === 'success') {
                        // Display the output when compilation is successful
                        document.getElementById('compilerOutput').textContent = data.output;
                    } else {
                        // Display an error message if there was a problem with compilation
                        document.getElementById('compilerOutput').textContent = data.message;
                    }

                    // Show the output area after compilation
                    document.getElementById('compilerOutput').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error:', error);  // Log any error to the console
                    document.getElementById('compilerOutput').textContent = "An error occurred during the compilation process.";
                    document.getElementById('compilerOutput').style.display = 'block';
                });
        });
    </script>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>