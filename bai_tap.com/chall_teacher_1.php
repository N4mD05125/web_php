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
if(empty($_POST["hint"])){
$url = 'http://localhost/teacher_dashboard.php';
$linkText = 'Return to dashboard!';
echo '<a href="' . $url . '">' . $linkText . '</a>';
echo "<br/>";
die("Request to enter hint!");

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "chall_file/";
    $target_file = $target_dir . basename($_FILES["file_homework"]["name"]);
    $uploadOk = 1;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['file_homework']['tmp_name']);
    finfo_close($finfo);

    if ($mimeType != 'text/plain') {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Only .txt files can be uploaded");
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', basename($_FILES["file_homework"]["name"]))) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("File name is not include special character");
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

		$filename = $target_file . " hint";

		$content = $_POST["hint"];

		$file = fopen($filename, "w");

		if ($file) {
			fwrite($file, $content);
			$content = file_get_contents($filename);
			fclose($file);
			echo "The challenge file has been uploaded with the hint:" .  $content . "<br/>";

			$url = 'http://localhost/teacher_dashboard.php';
	                $linkText = 'Return to dashboard!';
        	        echo '<a href="' . $url . '">' . $linkText . '</a>';
                	echo "<br/>";
	
		}		 
		else {
    			echo "Cant do anything!";
		}


	}
	else {
            die("Something went wrong during the upload");
        }
    }
} 
else {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Invalid request method");
}



?>
