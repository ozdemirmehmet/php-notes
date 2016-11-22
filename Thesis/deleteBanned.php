<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["bannedId"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$bannedId = $_GET['bannedId'];
 		
		$sql = "DELETE FROM banned WHERE banned_id='$bannedId'";
		
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