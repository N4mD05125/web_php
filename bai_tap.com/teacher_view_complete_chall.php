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



$file = "chall_file/student_complete_chall.txt";
$list_student = file_get_contents($file);
if(file_exists($file)){
	echo "Students who won the challenge: <br/>";
	echo $list_student . "<br/>";
	$url = 'http://localhost/student_dashboard.php';
	$linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";
}
else{
	$url = 'http://localhost/student_dashboard.php';
	$linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";
	die("Error");
}
