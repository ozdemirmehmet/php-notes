<?php

require_once("baglan.php");

if(isset($_GET["regId"])){
	
	$regId = $_GET['regId']; //Get metodu ile gelen regId alýnýr.
 	
	$sql = "INSERT INTO gcm_user (reg_id) VALUES ('$regId')";
	
	if(!mysqli_query($con,$sql)){
		die('MySQL query failed '.mysqli_error());
	}
}

mysqli_close($con);
?>