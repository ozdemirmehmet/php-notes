
<?php
	require_once("connect.php");
	if( isset($_POST["studentNo"]) & isset($_POST["password"]) ){
		header('content-type:text/html;charset=utf-8');
		$studentNo = $_POST["studentNo"];
		$password = $_POST["password"];

		$sql = "SELECT * FROM student WHERE studentNo='$studentNo' AND password='$password'";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Giriş başarılı
			$row = $result->fetch_assoc();

			/*$firstName = utf8_encode($row['firstName']);
			$lastName = utf8_encode($row['lastName']);
			$faculty = utf8_encode($row['faculty']);
			$department = utf8_encode($row['department']); 
			*/
			$firstName = $row['firstName'];
			$lastName = $row['lastName'];
			$faculty = $row['faculty'];
			$department = $row['department']; 
			
			$response = array(
				"response" => "OK",
				"student" => array(
					"id" => $row['id'],
					"firstName" => $firstName,
					"lastName" => $lastName,
					"faculty" => $faculty,
					"department" => $department
					)
				);
		}
		else{//Giriş başarısız
			$response = array(
				"response" => "NO"
				);
		}
		echo json_encode($response,JSON_UNESCAPED_UNICODE);
		mysqli_close($con);	
	}
?>