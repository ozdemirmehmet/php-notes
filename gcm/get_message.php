<?php

include("baglan.php");

if($_POST){
	
	$sql = "SELECT message FROM gcm_message ORDER BY message_id DESC LIMIT 1";
	
	$result = $con->query($sql);
	
	$row = $result->fetch_array();
	
	$message = $row["message"];
	
	$answer = array('message' => $message);
	
	echo json_encode($answer);
	
	$con->close();
}

else{
	
	echo "Giriş engellendi";
}




?>