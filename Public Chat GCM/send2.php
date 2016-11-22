<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Send Message</title>
</head>


 <?php
 
	require_once("baglan.php");//database baðlantýsý gercekleþtirdik
	if(isset($_POST['submit']) && isset($_POST['languages'])){//kontrol
    
	$languages = $_POST['languages'];
   	$registatoin_ids = array();//registration idlerimizi tutacak array ý oluþturuyoruz
	if(strcmp($languages,"All Languages") == 0){
		$sql = "SELECT * FROM userss";//Tüm kullanýcý gcm registration idlerini alýcak sql sorgumuz
	}
	else if(strcmp($languages,"Turkish") == 0) {
		$sql = "SELECT * FROM userss WHERE language = 'Türkçe'";
	}
	else{
		$sql = "SELECT * FROM userss WHERE language != 'Türkçe'";
	}
    
		
   
   $result = mysqli_query($con, $sql);//sorguyu çalýþtýrýyoruz
   while($row = mysqli_fetch_assoc($result)){
    array_push($registatoin_ids, $row['regId']);//databaseden dönen registration idleri $registatoin_ids arrayine atýyoruz
   }
  
   // GCM servicelerine gidecek veri
   //Arkadaþlar aþþaðýdaki PHP kodlarýyla oynamýyoruz. Bu Google 'n bizden kullanmamýzý istediði kodlar
   //Sadece registration_ids,mesaj ve Authorization: key deðerlerini deðiþtiriyoruz
    /*$url = 'https://android.googleapis.com/gcm/send';
    
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
		 echo "<div class=\"col-md-12\"><textarea style=\"resize:none; width:98%; position:absolute\" row=\"4\">".$result."</textarea></div>";*/
  }
 ?>
  


<style>
	html,body{
		background-color:#F0F0F0;
	}
</style>
<body>
	<div class="col-md-12" style="padding:5%"></div>
	<form class="form" method="post" action="send2.php">
		<div class="container">
			<div class="row">
				<div class="col-md-1" style="padding-top:0.3%"></div>
				<div class="col-md-1" style="padding-top:0.3%"></div>
				<div class="col-md-8" style="padding-top:0.3%">
					<div class="col-md-1"></div>
					<div class="col-md-10" style="border-radius:5px; border:1px solid; background-color:#FFFFFF; padding:4%">
						<div class="form-group">
							<label for="exampleInputName2" class="col-sm-2 control-label">Message</label>
							<div class="col-sm-10">
								<textarea name="mesaj" class="form-control" rows="7" placeholder="Type message..." style="resize:none"></textarea>
							</div>
						</div>
						<div class="col-md-12" style="height:2%" ></div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-8" style="padding:0px">
								<div class="col-md-12" style="padding-right:1%">
									<select name="languages" class="form-control">
										<option name="allLanguages">All Languages</option>
										<option name="turkce">Turkish</option>
										<option name="other">Other Languages</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary" style="float:right"/>
							</div>
						</div>
					</div>	
					<div class="col-md-1"></div>
				</div>
				<div class="col-md-1" style="padding-top:0.3%"></div>
				<div class="col-md-1" style="padding-top:0.3%"></div>
				<input type="hidden" name="sender" id="sender" value="admin" />
			</div>
		</div>
	</form>
</body>
</html>