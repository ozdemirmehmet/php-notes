<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["comment"]) & isset($_GET["androidId"]) & isset($_GET["rate"])
				& isset($_GET["licensePlate"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$comment = $_GET['comment'];
 		$androidId = $_GET['androidId'];
		$rate = $_GET['rate'];
 		$licensePlate = $_GET['licensePlate'];

		$sql = "SELECT * FROM customers WHERE customer_phone_id='$androidId'";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Eğer müşteri varsa
			$row = $result->fetch_assoc();

			$customerId = $row['customer_id'];//id sini al.

			$sql1 = "SELECT * FROM taxis WHERE taxi_license_plate='$licensePlate'";
			$result1 = $con->query($sql1);
			$row1 = $result1->fetch_assoc();
			$taxiId = $row1['taxi_id'];

			$sql = "INSERT INTO ratings (rating_rate,rating_comment,customer_id,taxi_id) values ('$rate','$comment','$customerId','$taxiId')";
		
			if(!mysqli_query($con, $sql)){//sorguyu çalıştırdık
  				die('MySQL query failed'.mysqli_error($con));
			}		
			else{//Kayıt başarılı
				$response = array(
					"response" => "OK"
					);	
			}
		} else {
			$response = array(
				"response" => "NO CUSTOMER"
				);	
		}
	 	echo json_encode($response);
 		mysqli_close($con);//veritabanı bağlantısı kapatıldı
 	}
	
?>