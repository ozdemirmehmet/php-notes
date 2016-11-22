<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if(isset($_GET)){
		$sql = "SELECT customers.customer_phone_id, banned.banned_comment, banned.banned_id 
				FROM banned INNER JOIN customers ON customers.customer_id = banned.customer_id";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Yasaklı müşteri varsa
			$response3 = array(); 
			while($row = $result->fetch_assoc()){
				$response2 = array(
					"banned_comment" => $row['banned_comment'],
					"banned_id" => $row['banned_id'],
					"phone_id" => $row['customer_phone_id']
					);
				array_push($response3, $response2);
			}
			$response = array(
				"response" => "OK",
				"customers" => $response3
				);
		} else {//Taksi yok
			$response = array(
				"response" => "NO BANNED"
				);
		}
		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
	}
?>