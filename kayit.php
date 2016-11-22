<?php

include("baglan.php");

if($_POST){
	
	$name = $_POST["name"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	
	$error = false;
	$resultmessage = "";
	
	if($name == ""){
		$error = true;
		$resultmessage = "Isim alani bos olamaz!";
	}
	if($email == ""){
		$error = true;
		$resultmessage = "Email bos olamaz!";
	}
	if(strlen($password) < 6){
		$error = true;
		$resultmessage = "Sifre 6 karakterden az olamaz!";
	}
	
	$sql = "SELECT * FROM users WHERE user_email='$email'";
	$result = $con->query($sql);
	if($result->num_rows > 0){
		$error = true;
		$resultmessage = "Email adresi sistemde kayitli!";
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$error = true;
		$resultmessage = "Hatali email formati!";
	}
	
	if(!$error){
		$sql = "INSERT INTO users (user_name,user_email,user_password,date)
				VALUES ('$name','$email','$password',NOW())";
		if(!$con->query($sql)){
			$resultmessage = mysqli_error($con);
			$answer = array('result' => "0", 'resultmessage' => $resultmessage);
		}
		else{
			$resultmessage = "Kayit basarili";
			$answer = array('result' => "1", 'resultmessage' => $resultmessage);
		}
		$con->close();
	}
	else{
		$answer = array('result' => "0", 'resultmessage' => $resultmessage);
	}
	echo json_encode($answer);
}
else{
	echo "Giris engellendi";
}


?>