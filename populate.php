<?php
	session_start();
	if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
		header('Location: login.php');
	}
?>

<?php
	include_once "connect.php";
	include_once "functions.php";

	$allowedExts = array("csv");
	$tmp = explode(".", $_FILES["file"]["name"]);
	$extension = end($tmp);
	if (($_FILES["file"]["type"] == "text/csv")
		&& ($_FILES["file"]["size"] < 200000)
		&& in_array($extension, $allowedExts)) {
		if ($_FILES["file"]["error"] > 0) {
			$_SESSION['acronyms_added'] = 1;
			// echo "Error: " . $_FILES["file"]["error"];
		} else {
			$_SESSION['acronyms_added'] = 2;
			// echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			// echo "Type: " . $_FILES["file"]["type"] . "<br>";
			// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		}

		populate($_FILES["file"]["tmp_name"]);
		mysql_close($con);
	} else { $_SESSION['acronyms_added'] = 0; }

	header('Location: admin.php');
?>