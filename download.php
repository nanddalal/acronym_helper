<?php
	session_start();
	if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
		header('Location: login.php');
	}
?>

<?php

	$filename = 'download-' . $_SESSION['username'] . '.csv';

	header("Content-type: text/csv");
	header("Cache-Control: no-store, no-cache");
	header('Content-Disposition: attachment; filename=' . $filename);

	include_once "connect.php";
	$query = sprintf("SELECT encoding, description FROM acronyms;");
	$result = mysql_query($query);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}

	$fp = fopen('php://output', 'w');
	while ($row = mysql_fetch_assoc($result)) {
		fputcsv($fp, $row);
	}
	fclose($fp);

	mysql_free_result($result);
	mysql_close($con);
?>