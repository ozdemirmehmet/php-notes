<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["fee"]) & isset($_GET["name"]) & isset($_GET["description"])
				& isset($_GET["licensePlate"]) & isset($_GET["androidId"])
				& isset($_GET["startLat"]) & isset($_GET["startLng"])
				& isset($_GET["endLat"]) & isset($_GET["endLng"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		
 		$fee = $_GET['fee'];
		$name = $_GET['name'];
		$description = $_GET['description'];
 		$licensePlate = $_GET['licensePlate'];
 		$androidId = $_GET['androidId'];
 		$startLat = $_GET['startLat'];
		$startLng = $_GET['startLng'];
		$endLat = $_GET['endLat'];
		$endLng = $_GET['endLng'];

		$sql = "SELECT * FROM customers WHERE customer_phone_id='$androidId'";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Eğer müşteri varsa
			$row = $result->fetch_assoc();

			$customerId = $row['customer_id'];//id sini al.

			$sql1 = "SELECT * FROM taxis WHERE taxi_license_plate='$licensePlate'";
			$result1 = $con->query($sql1);
			$row1 = $result1->fetch_assoc();
			$taxiId = $row1['taxi_id'];

			$sql2 = "INSERT INTO addresses (address_lat,address_lng) values ('$startLat','$startLng')";
			$con->query($sql2);
			$startId = $con->insert_id;

			$sql3 = "INSERT INTO addresses (address_lat,address_lng) values ('$endLat','$endLng')";
			$con->query($sql3);
			$endId = $con->insert_id;

			$date = date("Y-m-d H:i:s");

			$sql4 = "INSERT INTO jobs (job_date,job_fee,job_name,job_description,job_start_address_id,job_end_address_id,customer_id,taxi_id) 
									values ('$date','$fee','$name','$description','$startId','$endId','$customerId','$taxiId')";

			if(!mysqli_query($con, $sql4)){//sorguyu çalıştırdık
  				die('MySQL query failed'.mysqli_error($con));
			}		
			else{//Kayıt başarılı
				$response = array(
					"response" => "OK"
					);
			}
		} else {//Müşteri kayıtlı değilse
			$response = array(
				"response" => "NO RECORDED CUSTOMER"
				);
		}

		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
 	}
?>