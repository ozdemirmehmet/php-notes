<?php
 
	require_once("baglan.php");//database ba�lant�s� gercekle�tirdik
	if(isset($_POST['submit'])){//kontrol
    /*//deneme blo�u
		 $mesaj1 = $_POST['mesaj'];
   $sql1 = "INSERT INTO gcm_message (message) VALUES ('$mesaj1')";
   
	$con->query($sql1);
   
   //deneme blo�u sonu
		 */
   $registatoin_ids = array();//registration idlerimizi tutacak array � olu�turuyoruz
	if(strcmp($_POST['users'],"All Users") == 0){
		$sql = "SELECT * FROM gcm_user";//T�m kullan�c� gcm registration idlerini al�cak sql sorgumuz
	}
	else{
		$sql = "SELECT * FROM gcm_user WHERE id=". $_POST['users'];
	}
    
		
   
   $result = mysqli_query($con, $sql);//sorguyu �al��t�r�yoruz
   while($row = mysqli_fetch_assoc($result)){
    array_push($registatoin_ids, $row['reg_id']);//databaseden d�nen registration idleri $registatoin_ids arrayine at�yoruz
   }
  
   // GCM servicelerine gidecek veri
   //Arkada�lar a��a��daki PHP kodlar�yla oynam�yoruz. Bu Google 'n bizden kullanmam�z� istedi�i kodlar
   //Sadece registration_ids,mesaj ve Authorization: key de�erlerini de�i�tiriyoruz
    $url = 'https://android.googleapis.com/gcm/send';
    
    $mesaj = array("notification_message" => $_POST['mesaj'],"sender" => $_POST['sender']); //g�nderdi�imiz mesaj POST 'tan al�yoruz.Androidde okurken notification_message de�erini kullanaca��z
         $fields = array(
             'registration_ids' => $registatoin_ids,
             'data' => $mesaj,
         );
         
		
		 
		 
        //Alttaki Authorization: key= k�sm�na Google Apis k�sm�nda olu�turdu�umuz key'i yazaca��z
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