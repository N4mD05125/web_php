<?php
session_start();
$servername = "localhost";
$username = "tester";
$password = "password1234";
$dbname = "bai_tap";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    die("Invalid username or password");
}

$stmt = $conn->prepare("SELECT username, password, teacher FROM thong_tin WHERE username=?");
$stmt->bind_param("s", $username);

$stmt->execute();

$stmt->bind_result($db_username, $db_password, $teacher);

if ($stmt->fetch()) {
    if (sha1($password) == $db_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['teacher'] = $teacher;
        $_SESSION['username'] = $username;

        if ($teacher == 1) {
            header("Location: teacher_dashboard.php");
        } else {
            header("Location: student_dashboard.php");
        }
    } else {
        echo "Invalid password";
    }
} else {
    echo "User does not exist";
}

$stmt->close();
$conn->close();
?>

