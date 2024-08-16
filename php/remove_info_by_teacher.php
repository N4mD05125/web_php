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
<form action = "remove_info_by_teacher_1.php" method = "post">
	Type your password to confirm remove this student:
	<input type = "password" name = "confirm_password" required><br>
        <input type = "submit" value = "Confirm!" required><br>
    </form>
</html>


