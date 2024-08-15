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

if(empty($_POST['update_name'])){
	$url = 'http://localhost/student_dashboard.php';
	$linkText = 'Return to dashboard!';
	echo '<a href="' . $url . '">' . $linkText . '</a>';
	echo "<br/>";
	die("Name cannot be left blank!!!");
}
if(empty($_POST['update_sdt'])){
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Phone number cannot be left blank!!!");
}
if(empty($_POST['update_email'])){
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Email cannot be left blank!!!");
}
if(empty($_POST['update_password'])){
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Password cannot be left blank!!!");
}
if(empty($_POST['confirm_password'])){
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Enter password to confirm cannot be left blank!!!");
}

$update_name = $_POST['update_name'];
$update_sdt = $_POST['update_sdt'];
$update_email = $_POST['update_email'];
$update_password = sha1($_POST['update_password']);
$cf_password = sha1($_POST['confirm_password']);


$update_name = $_POST['update_name'];
$update_sdt = $_POST['update_sdt'];
$update_email = $_POST['update_email'];
$update_password = sha1($_POST['update_password']);
$cf_password = sha1($_POST['confirm_password']);


if (strlen($update_name)>50) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Your name too long, limit is 50 character!");
}
if (!preg_match('/^[a-zA-Z\s]+$/', $update_name)) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Your name is not include special character");
}
if (strlen($update_password)>50) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Your password too long, limit is 50 character!");
}
if (strlen($update_email)>50) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Your email too long, limit is 50 character");
}
if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $update_email)) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Wrong email form");
}
if (!preg_match('/^(0)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', $update_sdt)) {
	$url = 'http://localhost/student_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
	die("Invalid phone number!");
}


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
		    $url = 'http://localhost/student_dashboard.php';
        	    $linkText = 'Return to dashboard!';
        	    echo '<a href="' . $url . '">' . $linkText . '</a>';
        	    echo "<br/>";
            	    die("Incorrect confirm password");
	} else {
            $stmt = $conn->prepare("UPDATE thong_tin SET name=?, sdt=?, email=?, password=? WHERE username=?");
            $stmt->bind_param("sssss", $update_name, $update_sdt, $update_email, $update_password, $username);

	    if ($stmt->execute()) {
		    $url = 'http://localhost/student_dashboard.php';
                    $linkText = 'Return to dashboard!';
                    echo '<a href="' . $url . '">' . $linkText . '</a>';
                    echo "<br/>";
                    echo "Your information has been changed!" . "<br/>";
            } else {
                echo "Lmao: " . $stmt->error;
            }
        }
    }
} else {
    die("error");
}

