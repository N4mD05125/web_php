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

?>
<!DOCTYPE html>
<html>
<form action = "edit_info_by_student_2.php" method = "post">
	<h3>Edit your infomation here:</h3><br>
	Your name:
        <input type = "text" name = "update_name" required><br>
        Your phone number:
        <input type = "text" name = "update_sdt" required><br>
        Your email address:
        <input type = "text" name = "update_email" required><br>
        Your password
        <input type = "password" name = "update_password" required><br>
	Type your password to confirm update:
	<input type = "password" name = "confirm_password" required><br>
        <input type = "submit" value = "Confirm!" required><br>
    </form>
</html>
