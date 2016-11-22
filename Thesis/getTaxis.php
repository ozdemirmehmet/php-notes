<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if(isset($_GET)){
		$sql = "SELECT * FROM taxis";
		$result = $con->query($sql);
		if($result->num_rows > 0){
			$response3 = array();
			while($row = $result->fetch_assoc()){
				$taxiId = $row["taxi_id"];
				$sql2 = "SELECT * FROM ratings WHERE taxi_id='$taxiId'";
				$result2 = $con->query($sql2);
				$ratingCount = 0;
				$rate = 0;
				while($row2 = $result2->fetch_assoc()){
					$ratingCount++;
					$rate += $row2["rating_rate"];
				}
				if($ratingCount != 0){
					$rate = $rate/$ratingCount;
				}

				$response2 = array(
						"id" => $row['taxi_id'],
						"license_plate" => $row['taxi_license_plate'],
						"rate" => $rate
					);
				array_push($response3, $response2);
			}
			$response = array(
				"response" => "OK",
				"taxis" => $response3
				);
		} else {//Taksi yok
			$response = array(
				"response" => "NO TAXI"
				);
		}
		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
	}
?>