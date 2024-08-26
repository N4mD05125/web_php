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
<form action="chall_teacher_1.php" method="post" enctype="multipart/form-data">
	Select file to create challenge <br>
	<input type = "file" name = "file_homework" required><br>
	Enter a hint for the challenge<br>
	<input type = "text" name = "hint" required><br>
	<input type = "submit" value = "upload" required>
</form><br><br>

<form action="view_chall_teacher.php" method="post" enctype="multipart/form-data">
        View challenge <br>
	<button type="submit">View chall</button><br>
</form>


</html>
