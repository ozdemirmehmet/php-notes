<?php
  if(isset($_GET['message']) & isset($_GET['androidId']) & isset($_GET['licensePlate'])){//kontrol
    require_once("connect.php");//database bağlantısı gercekleştirdik
    
    $androidId = $_GET['androidId'];
    $registatoin_ids = array();//registration idlerimizi tutacak array ı oluşturuyoruz
    
    $sql = "SELECT customer_reg_id FROM customers WHERE customer_phone_id='$androidId'";
    $result = mysqli_query($con, $sql);//sorguyu çalıştırıyoruz
    while($row = mysqli_fetch_assoc($result)){
      array_push($registatoin_ids, $row['customer_reg_id']);//databaseden dönen registration idleri $registatoin_ids arrayine atıyoruz
    }
 
    // GCM servicelerine gidecek veri
    $url = 'https://android.googleapis.com/gcm/send';
   
    $message = array("notification_message" => $_GET['message'],
                    "license_plate" => $_GET['licensePlate']);
    $fields = array(
      'registration_ids' => $registatoin_ids,
      'data' => $message,
      );
		
		//Alttaki Authorization: key= kısmına Google Apis kısmında oluşturduğumuz key'i yazacağız
         $headers = array(
             'Authorization: key=AIzaSyD17gP_UCSTOHsDQGHoQBSdUIlZeBDKo2I', 
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
         echo $result;
  }
?>