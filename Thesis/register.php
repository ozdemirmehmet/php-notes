<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["regId"]) & isset($_GET["androidId"]) & isset($_GET["appVersion"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$regId = $_GET['regId']; 
 		$androidId = $_GET['androidId'];
 		$appVersion = $_GET['appVersion'];
 		//Öncelikle o android id de bir kayıt olup olmadığını kontrol ediyoruz.
 		$sql1 = "SELECT customer_app_version FROM customers WHERE customer_phone_id = '$androidId'";
 		$result = $con->query($sql1);
 		if($result->num_rows > 0){//Cihaz önceden kayıt edilmişse burası çalışacak
 			$row = $result->fetch_assoc();
 			if($row['customer_app_version'] != $appVersion){//Cihaz önceden kaydedilmiş fakat uygulama güncellenmiş olduğu için regId de güncellenecek
 				$sql = "UPDATE customers SET customer_reg_id='$regId', customer_app_version='$appVersion' WHERE customer_phone_id='$androidId'";
 				if(!mysqli_query($con, $sql)){//sorguyu çalýþtýrdýk
  					die('MySQL query failed'.mysqli_error($con));
				}
				else{//Kayıt başarılı
					$response = array(
						"response" => "UPDATE OK"
						);
				}
 			}
 			else{
 				$response = array(
					"response" => "NO PROCESS"
					);
 			}
 		}
 		else{//Cihaz önceden kayıt edilmemiş yeni kayıt gerçekleştirilecek
 			$sql = "INSERT INTO customers (customer_reg_id,customer_app_version,customer_phone_id) values ('$regId','$appVersion','$androidId')"; //regId yi database kaydedicek sorgu
 			if(!mysqli_query($con, $sql)){//sorguyu çalýþtýrdýk
  				die('MySQL query failed'.mysqli_error($con));
			}		
			else{//Kayıt başarılı
				$response = array(
					"response" => "RECORD OK"
					);
			}
 		}
 		echo json_encode($response);
 		mysqli_close($con);//veritabanı bağlantısı kapatıldı
 	}
?>