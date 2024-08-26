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

$directory = "chall_file/";

echo "<h1> Chall list </h1>";

if (is_dir($directory)) {
    $files = scandir($directory);

    foreach ($files as $file) {
	    if ($file !== '.' && $file !== '..' && $file !== 'student_complete_chall.txt') {
		echo "<h4>" . $file . "</h4>";
		echo '<form action="teacher_download_chall.php" method="post">';
                echo '<button type="submit" name="download" value="' . htmlspecialchars($file) . '">Download</button>';
                echo '</form>';

		echo '<form action="teacher_remove_chall.php" method="post">';
                echo '<button type="submit" name="remove" value="' . htmlspecialchars($file) . '">Remove this chall</button>';
                echo '</form>';
	}
    }
}
else {
    echo "The directory does not exist.";
}

echo '<form action="teacher_view_complete_chall.php" method="post">';
echo '<button type="submit" name="view">View who won the challenge</button>';
echo '</form>';


$url = 'http://localhost/teacher_dashboard.php';
$linkText = 'Return to dashboard!';
echo '<a href="' . $url . '">' . $linkText . '</a>';
echo "<br/>";

