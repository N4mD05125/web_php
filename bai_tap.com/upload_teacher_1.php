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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "upload_homework_file/";
    $target_file = $target_dir . basename($_FILES["file_homework"]["name"]);
    $uploadOk = 1;

    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['file_homework']['tmp_name']);
    finfo_close($finfo);

    if ($fileType != "txt" || $mimeType != 'text/plain') {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Only .txt files can be uploaded");        
    }
    if (file_exists($target_file)) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
  	die("Sorry, file already exists");
    }

    if ($uploadOk == 0) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("File was not uploaded");
    } 
    else {
        if (move_uploaded_file($_FILES["file_homework"]["tmp_name"], $target_file)) {
		echo "The file " . htmlspecialchars(basename($_FILES["file_homework"]["name"])) . " has been uploaded successfully" . "<br/>";
		$url = 'http://localhost/teacher_dashboard.php';
        	$linkText = 'Return to dashboard!';
        	echo '<a href="' . $url . '">' . $linkText . '</a>';
        	echo "<br/>";

	} 
	else {
            die("Something went wrong during the upload");
        }
    }
} else {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Invalid request method");
}


?>

