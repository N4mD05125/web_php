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
if (empty($_POST['username_id'])) {
    die("No users selected");
}

$servername = "localhost";
$username = "tester";
$password = "password1234";
$dbname = "bai_tap";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Deo ket noi duoc: " . $conn->connect_error);
}

$username = $_POST['username_id'];

$sql = "SELECT name, sdt, email, teacher FROM thong_tin WHERE username='$username'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Full name: " . $row["name"] . "<br/>";
        echo "Phone number: " . $row["sdt"] . "<br/>";
        echo "Email address: " . $row["email"] . "<br/>";
	if($row["teacher"]){
		echo "Teacher";
	}
	else{
		echo "Student";
	}
    }
}
else {
    echo "Khong tim thay thong tin";
}

$conn->close();

?>
