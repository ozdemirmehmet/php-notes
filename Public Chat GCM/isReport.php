<?php 
	require_once("baglan.php");//veritabanı bağlantısı
	if (isset($_POST["androidId"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$androidId = $_POST['androidId'];

 		$sql = "SELECT * FROM banned_user WHERE androidId = '$androidId'";
		$result = $con->query($sql);

		if($result->num_rows > 0){//Eğer kullanıcı banlı ise
			echo "NO";
		}
		else{
			echo "OK";
		}
 	}
 	else{
		echo "Giriş engellendi";
	}
	mysqli_close($con);//veritabanı bağlantısı kapatıldı
?>