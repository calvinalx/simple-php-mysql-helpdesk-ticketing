<?php
	/*
		print_r($_POST);
		print_r($_FILES);
  */
?>


<?php

	$last_file_insert_ID = 0;
	try{
		if(isset($_FILES['files'])){ 
			if ($_FILES['files']['error'] == 0) {
				$fileName = $_FILES['files']['name'];
				$tmpName  = $_FILES['files']['tmp_name'];
				$fileSize = $_FILES['files']['size'];
				$fileType = $_FILES['files']['type'];
				
				$fp      = fopen($tmpName, 'r');
				$content = fread($fp, filesize($tmpName));
				$content = addslashes($content);
				fclose($fp);
				
				if(!get_magic_quotes_gpc()){
				    $fileName = addslashes($fileName);
				}
				
				try{		
					$mysqli = new mysqli("localhost:3306", "root", "root", "userrequest");
					if ($mysqli->connect_errno) {
						die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
					}else{
						$date = date('Y-m-d H:i:s');
								
						//Insert a log row
						$sqlquery = "INSERT INTO upload (name, size, type, content ) VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
						$result = $mysqli->query($sqlquery);
						$last_file_insert_ID = $mysqli->insert_id;
						mysqli_close($mysqli);
					}
				}catch(Exception $e) {
					die('Error, query upload failed');
				}
			}
		}
	}catch(Exception $e) {}
	

	try{		
		$mysqli = new mysqli("localhost:3306", "root", "root", "userrequest");
		if ($mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}else{				
			//Insert a log row
			$sqlquery = "INSERT INTO request VALUES('','" . urlencode($_POST['support']) . "','" . urlencode($_POST['user_name']) . "','" . urlencode($_POST['user_id']) . "','" . urlencode($_POST['email']) . "','" . urlencode($_POST['application_code']) . "','" . urlencode($_POST['request_domain']) . "','" . urlencode($_POST['details']) . "', $last_file_insert_ID, '')";
			$result = $mysqli->query($sqlquery);
			mysqli_close($mysqli);
		}
	}catch(Exception $e) {
		die("error");
	}
	
	header('Location: index.html');
?>