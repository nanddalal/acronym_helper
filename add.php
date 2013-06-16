<?php
	session_start();
	if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
		header('Location: login.php');
	}

	$inEncoding = strtolower($_GET["inEncoding"]);
	$inDescription = strtolower($_GET["inDescription"]);
	include_once "connect.php";
	include_once "functions.php";
	$_SESSION['acronym_added'] = 0;
	if (!inDatabase($inEncoding, $inDescription)) {
		$newElt = sprintf("INSERT INTO acronyms (encoding, description) 
			VALUES ('%s', '%s');",
			mysql_real_escape_string($inEncoding),
			mysql_real_escape_string($inDescription));
		mysql_query($newElt);
		$_SESSION['acronym_added'] = 1;
	}
	mysql_close($con);

	header('Location: admin.php')
?>