<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["owner"]) & isset($_GET["model"]) & isset($_GET["brand"])
				& isset($_GET["licensePlate"]) & isset($_GET["password"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		
 		$licensePlate = $_GET['licensePlate'];
 		$password = $_GET['password'];
 		$brand = $_GET['brand'];
		$model = $_GET['model'];
		$owner = $_GET['owner'];

		$sql = "SELECT * FROM taxis WHERE taxi_license_plate='$licensePlate'";
		$result = $con->query($sql);
		if($result->num_rows <= 0){//Eğer taksi önceden kayıt edilmemişse
	
			$sql = "INSERT INTO taxis (taxi_license_plate,taxi_brand,taxi_model,taxi_owner,taxi_password) values ('$licensePlate','$brand','$model','$owner','$password')";
		
			if(!mysqli_query($con, $sql)){//sorguyu çalıştırdık
  				die('MySQL query failed'.mysqli_error($con));
			}		
			else{//Kayıt başarılı
				$response = array(
					"response" => "OK"
					);	
			}
		} else {//Taksi önceden kayıtlı ise
			$response = array(
				"response" => "RECORDED LICENSE PLATE"
				);	
		}
 	 	echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
 	}
?>