<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["phoneId"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$phoneId = $_GET["phoneId"];

		$sql = "SELECT banned.banned_id FROM banned INNER JOIN customers ON banned.customer_id = customers.customer_id WHERE customers.customer_phone_id = '$phoneId'";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Kullanıcı banlı kullanıcılar listesinde
			$response = array(
				"response" => "DENY"
				);
		} else {//İş yok
		$response = array(
				"response" => "ALLOW"
			);
		}
		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
	}
?>