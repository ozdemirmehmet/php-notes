<?php 
	require_once("baglan.php");//veritabanı bağlantısı
	if (isset($_POST["regId"]) & isset($_POST["androidId"]) & isset($_POST["language"]) & isset($_POST["appVersion"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$regId = $_POST['regId']; 
 		$androidId = $_POST['androidId'];
 		$language = $_POST['language'];
 		$appVersion = $_POST['appVersion'];
 		//Öncelikle o android id de bir kayıt olup olmadığını kontrol ediyoruz.
 		$sql1 = "SELECT regId FROM userss WHERE androidId = '$androidId'";
 		$result = $con->query($sql1);
 		if($result->num_rows > 0){//Cihaz önceden kayıt edilmişse burası çalışacak
 			$row = $result->fetch_assoc();
 			if($row['regId'] != $regId){//Cihaz önceden kaydedilmiş fakat uygulama güncellenmiş olduğu için regId de güncellenecek
 				$sql = "UPDATE userss SET regId='$regId' WHERE androidId='$androidId'";
 				if(!mysqli_query($con, $sql)){//sorguyu çalýþtýrdýk
  					die('MySQL query failed'.mysqli_error($con));
				}
				else{//Kayıt başarılı
					echo "OK";	
				}
 			}
 		}
 		else{//Cihaz önceden kayıt edilmemiş yeni kayıt gerçekleştirilecek
 			$sql = "INSERT INTO userss (regId,language,appVersion,androidId) values ('$regId','$language','$appVersion','$androidId')"; //regId yi database kaydedicek sorgu
 			if(!mysqli_query($con, $sql)){//sorguyu çalýþtýrdýk
  				die('MySQL query failed'.mysqli_error($con));
			}		
			else{//Kayıt başarılı
				echo "OK";	
			}
 		}
 	}
 	else{
		echo "Giriş engellendi";
	}
	mysqli_close($con);//veritabanı bağlantısı kapatıldı
?>