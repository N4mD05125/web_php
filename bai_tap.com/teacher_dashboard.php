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

$username = $_SESSION['username'];

$servername = "localhost";
$usernamedb = "tester";
$password = "password1234";
$dbname = "bai_tap";

$conn = new mysqli($servername, $usernamedb, $password, $dbname);
if ($conn->connect_error) {
    die("Deo ket noi duoc: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT name FROM thong_tin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = htmlspecialchars($row['name']);
    echo "<h2>Hello {$name}</h2> <p>Welcome to the teacher dashboard</p>";
} else {
    echo "Something wrong";
}

$stmt->close();
?>

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
	    margin-left: 700px;
	    margin-top: -40px;
	}

    </style>
</head>
<body>
    <div class="main-container">
        <div class="left-panel">
            <div class="content-block">
		<?php
		    echo '<div>';
		    echo "Upload homework here";
                    echo '<form action="upload_teacher.php" method="post" style="display:inline;">';
                    echo '<button id = "edit_info" type="submit" >Upload</button>';
                    echo '</form>';
		    echo '</div>';
		?>
            </div>
            <div class="content-block">
		<?php
                    echo '<div>';
                    echo "View assignments and answer from student";
                    echo '<form action="view_answer_teacher.php" method="post" style="display:inline;">';
                    echo '<button id = "edit_info" type="submit" >View</button>';
                    echo '</form>';
                    echo '</div>';
                ?>
            </div>
            <div class="content-block">
                Create and view challenge in here
		<form action = "chall_teacher.php" method = "post" style = "display:inline;">
		<button id = "edit_info" type = "submit" >click here</button>
		</form>
            </div>
        </div>

        <div class="right-panel">
            <?php
            $sql = "SELECT name, username FROM thong_tin";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="content-box">';
                    echo '<label>' . htmlspecialchars($row["name"]) . '</label>';
                    echo '<form action="view_and_edit_user.php" method="post" style="display:inline;">';
                    echo '<button type="submit" name="username_id" value="' . htmlspecialchars($row["username"]) . '">View</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo 'No students found';
            }
	    echo '<div class="content-box">';
            echo '<label>' . "Add more student here" . '</label>';
            echo '<form action="add_student_by_teacher.php" method="post" style="display:inline;">';
            echo '<button type="submit" >Add</button>';
            echo '</form>';
	    echo '</div>';

            $conn->close();
            ?>
        </div>
    </div>


<form action = "logout.php" method = "post">
	<button type="submit" required>Logout</button>
</form>
</body>
</html>




