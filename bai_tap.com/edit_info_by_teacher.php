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
$username = $_SESSION['username_edit'];
$servername = "localhost";
$usernamedb = "tester";
$password = "password1234";
$dbname = "bai_tap";

$conn = new mysqli($servername, $usernamedb, $password, $dbname);
if ($conn->connect_error) {
    die("Deo ket noi duoc: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT name, username, sdt, email FROM thong_tin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
else{
    echo "None";
}


?>

<!DOCTYPE html>
<html>
<form action = "edit_info_by_teacher_1.php" method = "post">
	<h3>Edit student infomation here:</h3><br>
	Username:
        <input type = "text" name = "update_username" value="<?php echo $row['username']; ?>" required><br>
	Name:
        <input type = "text" name = "update_name" value="<?php echo $row['name']; ?>" required><br>
        Phone number:
        <input type = "text" name = "update_sdt" value="<?php echo $row['sdt']; ?>" required><br>
        Email address:
        <input type = "text" name = "update_email" value="<?php echo $row['email']; ?>" required><br>
        Password:
        <input type = "password" name = "update_password" required><br>
	Type your password to confirm update:
	<input type = "password" name = "confirm_password" required><br>
        <input type = "submit" value = "Confirm!" required><br>
    </form>
</html>


<?php
$conn->close();

?>
