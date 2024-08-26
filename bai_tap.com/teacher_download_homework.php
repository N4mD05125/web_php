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

if (empty($_POST["download"])) {
    $url = 'http://localhost/teacher_dashboard.php';
    $linkText = 'Return to dashboard!';
    echo '<a href="' . $url . '">' . $linkText . '</a>';
    echo "<br/>";
    die("???");
}


$file = 'upload_homework_file/' . $_POST["download"];

if (file_exists($file)) {

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    ob_clean();
    flush();

    readfile($file);
    exit;
} 
else {
	echo "File does not exist" . "<br/>";
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";

}
?>


