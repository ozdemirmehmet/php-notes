<?php
include("baglan.php");

if($_POST){
	$email = $_POST["email"];
	$password = $_POST["password"];
	
	$error = false;
	$resultmessage = "";
	
	if($email == ""){
		$error = true;
		$resultmessage = "Mail adresiniz bos olamaz!";
	}
	if(strlen($password) < 6){
		$error = true;
		$resultmessage = "Sifre en az 6 karakter olmalidir!";
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$error = true;
		$resultmessage = "Hatali email formati!";
	}
	
	if(!$error){//Hata yoksa
		
		$sql = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password'";
		$result = $con->query($sql);
		if($result->num_rows > 0){
			$resultmessage = "Giris Basarili";
			$answer = array('result' => "0",'resultmessage' => $resultmessage);
		}
		else{
			$resultmessage = "Kullanici bulunamadi";
			$answer = array('result' => "0", 'resultmessage' => $resultmessage);
		}
		$con->close();
	}
	else{
		$answer = array('result' => "0", 'resultmessage' => $resultmessage);
	}
	//echo $answer."";
	echo json_encode($answer);
}
else{
		echo "Giris engellendi";
	}

?>