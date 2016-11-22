<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> <!--Türkçe karakter sorunu yaşamamak için-->
 
 <title>GCM Send</title>
</head>
<body>
 <?php
  if(isset($_POST['submit'])){//kontrol
   require_once("baglan.php");//database bağlantısı gercekleştirdik
   
   $registatoin_ids = array();//registration idlerimizi tutacak array ı oluşturuyoruz
    
   $sql = "SELECT * FROM gcm_user";//Tüm kullanıcı gcm registration idlerini alıcak sql sorgumuz
   $result = mysqli_query($con, $sql);//sorguyu çalıştırıyoruz
   while($row = mysqli_fetch_assoc($result)){
    array_push($registatoin_ids, $row['reg_id']);//databaseden dönen registration idleri $registatoin_ids arrayine atıyoruz
   }
  
   // GCM servicelerine gidecek veri
   //Arkadaşlar aşşağıdaki PHP kodlarıyla oynamıyoruz. Bu Google 'n bizden kullanmamızı istediği kodlar
   //Sadece registration_ids,mesaj ve Authorization: key değerlerini değiştiriyoruz
    $url = 'https://android.googleapis.com/gcm/send';
    
    $mesaj = array("notification_message" => $_POST['mesaj']); //gönderdiğimiz mesaj POST 'tan alıyoruz.Androidde okurken notification_message değerini kullanacağız
         $fields = array(
             'registration_ids' => $registatoin_ids,
             'data' => $mesaj,
         );
         
		 
		 //deneme bloğu
		 $mesaj1 = $_POST['mesaj'];
   $sql1 = "INSERT INTO gcm_message (message) VALUES ('$mesaj1')";
   
	$con->query($sql1);
   
   //deneme bloğu sonu
		 
		 
		 
        //Alttaki Authorization: key= kısmına Google Apis kısmında oluşturduğumuz key'i yazacağız
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
         echo $result;
  }
 ?>
  
 <form method="post" action="send.php">
  <label>Mesajı giriniz: </label><input type="text" name="mesaj" />
  
  <input type="submit" name="submit" value="Send" />
 </form>
</body>
</html>