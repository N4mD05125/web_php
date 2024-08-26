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

?>

<!DOCTYPE html>
<html>
<form action = "add_student_by_teacher_1.php" method = "post">
	<h3>Add student infomation here:</h3><br>
	Student name:
        <input type = "text" name = "update_name" required><br>
        Student phone number:
        <input type = "text" name = "update_sdt" required><br>
        Student email address:
	<input type = "text" name = "update_email" required><br>
	Student username:
        <input type = "text" name = "update_username" required><br>
        Student password:
	<input type = "password" name = "update_password" required><br>
	Type your password to confirm add:
	<input type = "password" name = "confirm_password" required><br>
        <input type = "submit" value = "Confirm!" required><br>
</form>
</html>




