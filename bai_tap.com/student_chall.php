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

$directory = "chall_file/";

echo "<h1> Chall listt </h1>";

if (is_dir($directory)) {
    $files = scandir($directory);

    foreach ($files as $file) {
	    if (strpos($file, "hint") !== false) {
		    $filename = $directory . $file;
		    $hint = file_get_contents($filename);
		    echo "Hint for chall: " . $hint . "<br/>";
		    echo '<form action="student_win_chall.php" method="post">';
		    echo '<input type = "text" name = "answer_chall" required>' . "<br/>";
		    echo '<button type="submit" name="name_chall" value="' . htmlspecialchars($file) . '">Check</button>';
                    echo '</form>';
    	}
    }
}
else {
    echo "The directory does not exist.";
}

$url = 'http://localhost/student_dashboard.php';
$linkText = 'Return to dashboard!';
echo '<a href="' . $url . '">' . $linkText . '</a>';
echo "<br/>";


