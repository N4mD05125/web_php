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


$directory = "upload_homework_file/";

echo "<h1> Assignments list </h1>";

if (is_dir($directory)) {
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
		echo "<h4>" . $file . "</h4>";
		echo '<form action="teacher_download_homework.php" method="post">';
                echo '<button type="submit" name="download" value="' . htmlspecialchars($file) . '">Download</button>';
                echo '</form>';

		echo '<form action="teacher_remove_homework.php" method="post">';
                echo '<button type="submit" name="remove" value="' . htmlspecialchars($file) . '">Remove this assignments</button>';
                echo '</form>';


        }
    }
} 
else {
    echo "The directory does not exist.";
}
echo "<br/>" . '<form action="teacher_view_homework.php" method="post">';
echo '<button type="submit" name="answer">See who submitted the answer</button>';
echo '</form>';
?>


