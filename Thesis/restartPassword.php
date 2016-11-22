<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if(isset($_GET["license_plate"])){
		$licensePlate = $_GET["license_plate"];
		$sql = "UPDATE taxis SET taxi_password = '123456' WHERE taxi_license_plate = '$licensePlate'";

		if(!mysqli_query($con, $sql)){//sorguyu çalıştırdık
  			die('MySQL query failed'.mysqli_error($con));
		}		
		else{//Kayıt başarılı
			$response = array(
				"response" => "OK"
				);
		}

		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
	}
?>