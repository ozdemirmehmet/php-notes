<?php
include("baglan.php");

if($_POST){
	$sql = "SELECT * FROM users";//Kayitli kullanýcýlar alýnýr
	$result = $con->query($sql);
	$json=array();
	//mysql_fetch_array($result)
	while($row = $result->fetch_array()){
		$name = $row["user_name"];
		$email = $row["user_email"];
		$json1 = array('name' => $name,'email'=>$email);
		array_push($json,$json1);
	}
	echo json_encode($json);
}


?>