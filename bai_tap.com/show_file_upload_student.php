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

$directory = "upload_homework_file/";

echo "<h1> Assignments list </h1>";

if (is_dir($directory)) {
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
		echo "<h4>" . $file . "</h4>";
		echo '<form action="student_download_homework.php" method="post">';
                echo '<button type="submit" name="download" value="' . htmlspecialchars($file) . '">Download</button>';
                echo '</form>';

    		echo '<form action="student_upload_homework.php" method="post">';
		echo '<button type="submit" name="answer" value="' . htmlspecialchars($file) . '">Upload answer</button>';
		echo '</form>';

        }
    }
} else {
    echo "The directory does not exist.";
}
?>

