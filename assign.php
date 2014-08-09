<?php
	/*
		print_r($_POST);
		print_r($_FILES);
  */
?>


<?php

	try{		
		$mysqli = new mysqli("localhost:3306", "root", "root", "userrequest");
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}else{				
			//Update assigned
			$sqlquery = "UPDATE request SET request.assigned='" . $_POST['assign_id'] . "' WHERE request.id='" . $_POST['row_id'] . "';";
			$result = $mysqli->query($sqlquery);
			mysqli_close($mysqli);
		}
	}catch(Exception $e) {
		die("error");
	}

?>
