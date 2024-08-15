<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }

        .main-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .left-panel {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .content-block {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            flex-grow: 1;
        }

        .right-panel {
            flex: 1;
            padding-left: 20px;
            overflow-y: auto;
            max-height: calc(100vh - 160px);
        }

        .content-box {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-box label {
            font-size: 16px;
        }

        .content-box button[type="submit"] {
            background-color: transparent;
            border: none;
            color: #008000;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            text-decoration: underline;
        }
        .content-box button[type="submit"]:hover {
            color: #006400;
	}
	#edit_info{
	    background-color: transparent;
            border: none;
            color: #008000;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
	    text-decoration: underline;
	    color: #006400;
	}	
	
    </style>

<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}
if ($_SESSION['teacher'] == 0) {
    header("Location: student_dashboard.php");
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
		echo "Teacher" . "<br/>";
	}
	else{
		$_SESSION['username_edit'] = $username;
		echo "Student" . "<br/>";
		echo '<div>';
		echo '<form action="edit_info_by_teacher.php" method="post" style="display:inline;">';
        	echo '<button id = "edit_info" type="submit" >Edit</button>';
        	echo '</form>';
		echo '</div>';
	}
    }
}
else {
    echo "Khong tim thay thong tin";
}

$conn->close();

?>

