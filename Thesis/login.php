<?php
	require_once("connect.php");
	header('content-type:text/html;charset=utf-8');
	if( isset($_GET["licensePlate"]) & isset($_GET["password"]) & isset($_GET["app"])){
		header('content-type:text/html;charset=utf-8');
		$licensePlate = $_GET["licensePlate"];
		$password = $_GET["password"];
		$app = $_GET["app"];

		if($app == "station"){
			$sql = "SELECT * FROM taxis WHERE taxi_id=1 AND taxi_license_plate='$licensePlate' AND taxi_password='$password'";
		} else if ($app == "taxi"){
			$sql = "SELECT * FROM taxis WHERE taxi_id!=1 AND taxi_license_plate='$licensePlate' AND taxi_password='$password'";
		}
		$result = $con->query($sql);
		if($result->num_rows > 0){//Giriş başarılı
			//$row = $result->fetch_assoc();

			$response = array(
				"response" => "OK"
				);
		}
		else{//Giriş başarısız
			$response = array(
				"response" => "NO"
				);
		}
		echo json_encode($response);
		mysqli_close($con);	
	}
?>