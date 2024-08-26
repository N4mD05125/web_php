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
$username = $_SESSION['username'];
$servername = "localhost";
$usernamedb = "tester";
$password = "password1234";
$dbname = "bai_tap";

$conn = new mysqli($servername, $usernamedb, $password, $dbname);
if ($conn->connect_error) {
    die("Deo ket noi duoc: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT sdt, email, password FROM thong_tin WHERE username = ?");
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
<form action = "edit_info_by_student_2.php" method = "post">
	<h3>Edit your infomation here:</h3><br>
        Your phone number:
        <input type = "text" name = "update_sdt" value="<?php echo $row['sdt']; ?>" required><br>
        Your email address:
        <input type = "text" name = "update_email" value="<?php echo $row['email']; ?>" required><br>
        Your password
        <input type = "password" name = "update_password" required><br>
	Type your password to confirm update:
	<input type = "password" name = "confirm_password" required><br>
        <input type = "submit" value = "Confirm!" required><br>
    </form>
</html>

<?php
$conn->close();
?>
