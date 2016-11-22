<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["comment"]) & isset($_GET["androidId"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$comment = $_GET['comment'];
 		$androidId = $_GET['androidId'];

		$sql = "SELECT * FROM customers WHERE customer_phone_id='$androidId'";
		$result = $con->query($sql);
		if($result->num_rows > 0){//Eğer müşteri varsa
			$row = $result->fetch_assoc();

			$customerId = $row['customer_id'];//id sini al.

			$sql2 = "SELECT * FROM banned WHERE customer_id='$customerId'";
			$result2 = $con->query($sql2);
			if($result2->num_rows > 0){//Müşteri zaten yasaklı
				echo "RECORDED CUSTOMER";
			} 
			else {//Müşteri yasaklı değil yasaklanacak
				$sql3 = "INSERT INTO banned (banned_comment,customer_id) values ('$comment','$customerId')";
		
				if(!mysqli_query($con, $sql3)){//sorguyu çalıştırdık
  					die('MySQL query failed'.mysqli_error($con));
				}		
				else{//Kayıt başarılı
					$response = array(
						"response" => "OK"
						);
				}
			}
		} 
		else {
			$response = array(
					"response" => "NO CUSTOMER"
					);
		}
		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
 	}
?>