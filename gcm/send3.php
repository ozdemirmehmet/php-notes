<?php
 
	require_once("baglan.php");//database baðlantýsý gercekleþtirdik
	if(isset($_POST['submit'])){//kontrol
    /*//deneme bloðu
		 $mesaj1 = $_POST['mesaj'];
   $sql1 = "INSERT INTO gcm_message (message) VALUES ('$mesaj1')";
   
	$con->query($sql1);
   
   //deneme bloðu sonu
		 */
   $registatoin_ids = array();//registration idlerimizi tutacak array ý oluþturuyoruz
	if(strcmp($_POST['users'],"All Users") == 0){
		$sql = "SELECT * FROM gcm_user";//Tüm kullanýcý gcm registration idlerini alýcak sql sorgumuz
	}
	else{
		$sql = "SELECT * FROM gcm_user WHERE id=". $_POST['users'];
	}
    
		
   
   $result = mysqli_query($con, $sql);//sorguyu çalýþtýrýyoruz
   while($row = mysqli_fetch_assoc($result)){
    array_push($registatoin_ids, $row['reg_id']);//databaseden dönen registration idleri $registatoin_ids arrayine atýyoruz
   }
  
   // GCM servicelerine gidecek veri
   //Arkadaþlar aþþaðýdaki PHP kodlarýyla oynamýyoruz. Bu Google 'n bizden kullanmamýzý istediði kodlar
   //Sadece registration_ids,mesaj ve Authorization: key deðerlerini deðiþtiriyoruz
    $url = 'https://android.googleapis.com/gcm/send';
    
    $mesaj = array("notification_message" => $_POST['mesaj'],"sender" => $_POST['sender']); //gönderdiðimiz mesaj POST 'tan alýyoruz.Androidde okurken notification_message deðerini kullanacaðýz
         $fields = array(
             'registration_ids' => $registatoin_ids,
             'data' => $mesaj,
         );
         
		
		 
		 
        //Alttaki Authorization: key= kýsmýna Google Apis kýsmýnda oluþturduðumuz key'i yazacaðýz
         $headers = array(
             'Authorization: key=AIzaSyDdq3eYrrD0B1YO8e_BVDce-3H4fLPG9vc', 
             'Content-Type: application/json'
         );
         // Open connection
         $ch = curl_init();
    
         // Set the url, number of POST vars, POST data
         curl_setopt($ch, CURLOPT_URL, $url);
    
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
         // Disabling SSL Certificate support temporarly
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
         // Execute post
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Curl failed: ' . curl_error($ch));
         }
    
         // Close connection
         curl_close($ch);
         //echo $result;
		 echo $result;
  }
 ?>