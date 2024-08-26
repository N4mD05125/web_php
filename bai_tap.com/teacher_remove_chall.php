<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

if ($_SESSION['teacher'] != 1) {
    header("Location: student_dashboard.php");
    exit;
}
if (empty($_POST["remove"])) {
    $url = 'http://localhost/teacher_dashboard.php';
    $linkText = 'Return to dashboard!';
    echo '<a href="' . $url . '">' . $linkText . '</a>';
    echo "<br/>";
    die("???");
}
$file = 'chall_file/' . $_POST["remove"];;

if (unlink($file)) {
	echo "The file was deleted successfully" . "</br>";
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
} else {
	echo "The file was deleted without success" . "<br/>";
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
}


