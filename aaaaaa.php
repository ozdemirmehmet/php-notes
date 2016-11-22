<?php

if(isset($_GET["regId"])){
	$json = "Hos Geldin";
	$data2 = array( 'name' => 'sss', 'age' => -1 );
	//header('Content-Type: application/json');
	//header('Content-Type: application/json;charset=utf-8;');
	echo json_encode($data2);	
}

if(isset($_POST["regId"])){
	class Emp {
      public $name = "";
      public $hobbies  = "";
      //public $birthdate = "";
   }
	
   $e = new Emp();
   $e->name = "sachin";
   $e->hobbies  = "sports";
   //$e->birthdate = date('m/d/Y h:i:s a', "8/5/1974 12:20:03 p");
   //$e->birthdate = date('m/d/Y h:i:s a', strtotime("8/5/1974 12:20:03"));

	//header('Content-Type: application/json;charset=utf-8;');
   echo json_encode($e);
	
}


?>