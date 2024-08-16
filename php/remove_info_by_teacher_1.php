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

$username_edit = $_SESSION['username_edit'];
$username = $_SESSION['username'];


if(empty($_POST['confirm_password'])){
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Enter password to confirm cannot be left blank!!!");
}
$cf_password = sha1($_POST['confirm_password']);
$servername = "localhost";
$usernamedb = "tester";
$password = "password1234";
$dbname = "bai_tap";

$conn = new mysqli($servername, $usernamedb, $password, $dbname);
if ($conn->connect_error) {
    die("Deo ket noi duoc: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT password FROM thong_tin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	    if (!($row["password"] == $cf_password)) {
		$url = 'http://localhost/teacher_dashboard.php';
		$linkText = 'Return to dashboard!';
		echo '<a href="' . $url . '">' . $linkText . '</a>';
		echo "<br/>";
            	die("Incorrect confirm password");
	}
	else {
            $stmt = $conn->prepare("DELETE FROM thong_tin WHERE username = ?");
            $stmt->bind_param("s", $username_edit);

            if ($stmt->execute()) {
		    echo "Your student information has been removed!" . "<br/>";
		    $url = 'http://localhost/teacher_dashboard.php';
        	    $linkText = 'Return to dashboard!';
        	    echo '<a href="' . $url . '">' . $linkText . '</a>';
        	    echo "<br/>";
            } else {
                echo "Lmao: " . $stmt->error;
            }
        }
    }
}
else {
    die("Error");
}






