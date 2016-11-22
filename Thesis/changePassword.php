<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["oldPassword"]) & isset($_GET["newPassword"]) & isset($_GET["licensePlate"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$licensePlate = $_GET['licensePlate'];
 		$oldPassword = $_GET['oldPassword'];
 		$newPassword = $_GET['newPassword'];

		$sql = "SELECT * FROM taxis WHERE taxi_license_plate='$licensePlate' AND taxi_password='$oldPassword'";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Giriş başarılı
			//$row = $result->fetch_assoc();

			$sql2 = "UPDATE taxis SET taxi_password = '$newPassword' WHERE taxi_license_plate = '$licensePlate'";

			if(!mysqli_query($con, $sql2)){//sorguyu çalıştırdık
  				die('MySQL query failed'.mysqli_error($con));
			}		
			else{//Kayıt başarılı
				$response = array(
					"response" => "OK"
					);
			}
		}
		else{//Giriş başarısız
			$response = array(
				"response" => "WRONG PASSWORD"
				);
		}
		echo json_encode($response);
		mysqli_close($con);	
	}
?>