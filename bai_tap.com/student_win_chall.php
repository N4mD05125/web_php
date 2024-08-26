<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

if ($_SESSION['teacher'] == 1) {
    header("Location: teacher_dashboard.php");
    exit;
}

if(empty($_POST['answer_chall'])){
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Invalid answer");
}
if(empty($_POST['name_chall'])){
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Click the button pls");
}

$directory = "chall_file/";
$check_answer = $_POST["answer_chall"] . " hint";

if($check_answer === $_POST['name_chall']){
	$remove = " hint";
	$result = str_replace($remove, "", $check_answer);

	$file = $directory . $result;
	echo "<h2>Correct answer!!</h2>" . "<br/>";
	echo '<form action="student_win_download.php" method="post">';
        echo '<button type="submit" name="download" value="' . htmlspecialchars($file) . '">Download the file for the winner</button>';
        echo '</form>';

	echo "<br/>";
	$url = 'http://localhost/teacher_dashboard.php';
	$linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";
}
else{
	echo "Wrong, try again!";
	$url = 'http://localhost/teacher_dashboard.php';
	$linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";

}
