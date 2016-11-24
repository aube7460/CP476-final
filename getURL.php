<?php
		$con = mysql_connect("localhost", "leun4090", "bigtop6");
		if (!$con){
			die("Could not connect: ".mysql_error());
		}
		$db = mysql_select_db("leun4090", $con);

		$title = $_POST['title'];
					
		$query = mysql_query("SELECT * FROM `books` WHERE title='$title'");
		$array = mysql_fetch_row($query);

		echo json_encode($array);
		mysql_close($con);
?>