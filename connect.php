<?php
	$con = mysql_connect("localhost","root","");
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	}
	//$sql = "SELECT * FROM Person";
	//mysql_query($sql,$con);
	mysql_select_db("acronyms");
?>
