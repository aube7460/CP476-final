<?php

	$username = $_POST['loginuser'];
	$password = $_POST['loginpw'];
	$password = sha1($password);
			
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter
	$con = mysql_connect("localhost", "aube7460", "LMNtrix2");
		
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
			
	// Selecting Database			
	$db = mysql_select_db("aube7460", $con);
			
	// SQL query to fetch information of registerd users and finds user match.
	$sql = "select * from finalLogin where password='$password' AND username='$username'";
	$query = mysql_query($sql, $con) or die(mysql_error());
	if ($query && mysql_num_rows($query) > 0){
		echo (1);
	}else{
		echo (0);
	}
	mysql_close($connection); // Closing Connection
?>