<?php
		
	$username = $_POST['createuser'];
	$password = $_POST['createpw'];
	$password = sha1($password);
		
	$con = mysql_connect("localhost", "aube7460", "LMNtrix2");
	$db = mysql_select_db("aube7460",$con);
		
	$sql = "INSERT INTO finalLogin VALUES ('$username', '$password')";
		
	$result = mysql_query($sql,$con) or die(mysql_error());

	mysql_close();
?>
