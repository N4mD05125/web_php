<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

if ($_SESSION['teacher'] != 1) {
    header("Location: teacher_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<html>
<form action="upload_teacher_1.php" method="post" enctype="multipart/form-data">
	Select your file to upload <br>
	<input type = "file" name = "file_homework" required><br>
	<input type = "submit" value = "upload" required>
</html>
