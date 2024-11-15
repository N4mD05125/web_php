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

$username_edit = $_SESSION['username_edit'];
$username = $_SESSION['username'];

if(empty($_POST['update_name'])){
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
	die("Name cannot be left blank!!!");
}
if(empty($_POST['update_sdt'])){
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Phone number cannot be left blank!!!");
}
if(empty($_POST['update_email'])){
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Email cannot be left blank!!!");
}
if(empty($_POST['update_password'])){
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Password cannot be left blank!!!");
}
if(empty($_POST['update_username'])){
        $url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
	die("Username cannot be left blank!!!");
}
if(empty($_POST['confirm_password'])){
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Enter password to confirm cannot be left blank!!!");
}

$update_name = $_POST['update_name'];
$update_sdt = $_POST['update_sdt'];
$update_email = $_POST['update_email'];
$update_password = sha1($_POST['update_password']);
$update_username = $_POST['update_username'];
$cf_password = sha1($_POST['confirm_password']);


if (strlen($update_name)>50) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
	die("Name too long, limit is 50 character!");
}
if (!preg_match('/^[a-zA-Z\s]+$/', $update_name)) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Name is not include special character");
}
if (strlen($update_username)>50) {
        $url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Username too long, limit is 50 character!");
}
if (strlen($update_password)>50) {$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Password too long, limit is 50 character!");
}
if (strlen($update_email)>50) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Email too long, limit is 50 character");
}
if (!preg_match('/^[a-zA-Z0-9_]+$/', $update_username)) {
        $url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Username only includes the characters A to Z, a to z, 0 to 9 and _");
}
if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $update_email)) {
	$url = 'http://localhost/teacher_dashboard.php';
        $linkText = 'Return to dashboard!';
        echo '<a href="' . $url . '">' . $linkText . '</a>';
        echo "<br/>";
        die("Wrong email form");
}
if (!preg_match('/^(0)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/', $update_sdt)) {
	$url = 'http://localhost/teacher_dashboard.php';
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
		$url = 'http://localhost/teacher_dashboard.php';
		$linkText = 'Return to dashboard!';
		echo '<a href="' . $url . '">' . $linkText . '</a>';
		echo "<br/>";
            	die("Incorrect confirm password");
	    }
	    else if($row['teacher']==1){
	    	die("Lmaoo");
	    }
	else {
            $stmt = $conn->prepare("UPDATE thong_tin SET username=?, password=?, name=?, email=?, sdt=? WHERE username=?");
            $stmt->bind_param("ssssss", $update_username, $update_password, $update_name, $update_email, $update_sdt, $username_edit);

            if ($stmt->execute()) {
		    echo "Your information has been changed!" . "<br/>";
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


