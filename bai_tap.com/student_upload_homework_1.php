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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "answer_homework_file/";
    $target_file = $target_dir . basename($_FILES["file_homework"]["name"]);
    $uploadOk = 1;

    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES['file_homework']['tmp_name']);
    finfo_close($finfo);

    if ($fileType != "txt" || $mimeType != 'text/plain') {
	unset($_SESSION['answer']);
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";
        die("Only .txt files can be uploaded");        
    }
    if ($uploadOk == 0) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";
	unset($_SESSION['answer']);
        die("File was not uploaded");
    } 
    $oldname = $target_file;
    $newname = $target_dir . $_SESSION['username'] . "_" . $_SESSION['answer'] . "_" .htmlspecialchars(basename($_FILES["file_homework"]["name"]));
    if (file_exists($newname)) {
	 $url = 'http://localhost/student_dashboard.php';
         $linkText = 'Return to dashboard!';
	 echo '<a href="' . $url . '">' . $linkText . '</a>';
	 echo "<br/>";
	 unset($_SESSION['answer']);
         die("Sorry, file already exists");
    }

    else {
        if (move_uploaded_file($_FILES["file_homework"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file_homework"]["name"])) . " has been uploaded successfully";

	    if (rename($oldname, $newname)) {
		    echo "!" . "<br/>";
		    unset($_SESSION['answer']);
		    $url = 'http://localhost/student_dashboard.php';
		    $linkText = 'Return to dashboard!';
		    echo '<a href="' . $url . '">' . $linkText . '</a>';
	    } 
	    else {
		    echo "?";
		    $url = 'http://localhost/student_dashboard.php';
                    $linkText = 'Return to dashboard!';
                    echo '<a href="' . $url . '">' . $linkText . '</a>';

	    }


	} 
	else {
	    $url = 'http://localhost/student_dashboard.php';
            $linkText = 'Return to dashboard!';
	    echo '<a href="' . $url . '">' . $linkText . '</a>';
	    echo "<br/>";
	    unset($_SESSION['answer']);
            die("Something went wrong during the upload");
        }
    }
} 
else {
    $url = 'http://localhost/student_dashboard.php';
    $linkText = 'Return to dashboard!';
    echo '<a href="' . $url . '">' . $linkText . '</a>';
    echo "<br/>";
    unset($_SESSION['answer']);
    die("Invalid request method");
}

?>


