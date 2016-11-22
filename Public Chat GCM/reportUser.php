<?php 
	require_once("baglan.php");//veritabanı bağlantısı
	if (isset($_POST["androidId"]) & isset($_POST["language"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$androidId = $_POST['androidId'];
 		$language = $_POST['language'];
 		$date = date("Y/m/d");

 		$sql = "INSERT INTO banned_user (language,androidId,date) values ('$language','$androidId','$date')";
		
		if(!mysqli_query($con, $sql)){//sorguyu çalıştırdık
  			die('MySQL query failed'.mysqli_error($con));
		}		
		else{//Kayıt başarılı
			echo "OK";	
		}
 	}
 	else{
		echo "Giriş engellendi";
	}
	mysqli_close($con);//veritabanı bağlantısı kapatıldı
?>