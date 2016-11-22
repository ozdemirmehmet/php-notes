<?php
	require_once("baglan.php");
	
	if($_POST){
		$sql = "SELECT id FROM gcm_user";
		$result = $con->query($sql);
		$json = array();
		while($row = $result->fetch_array()){
			$id = $row["id"];
			$json1 = array('id'=> $id);
			array_push($json,$json1);
		}
		echo json_encode($json);
	}
?>