<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Send Message</title>
</head>


 <?php
 
	require_once("baglan.php");//database bağlantısı gercekleştirdik
	if(isset($_POST['submit'])){//kontrol
    //deneme bloğu
		 $mesaj1 = $_POST['mesaj'];
   $sql1 = "INSERT INTO gcm_message (message) VALUES ('$mesaj1')";
   
	$con->query($sql1);
   
   //deneme bloğu sonu
		 
   $registatoin_ids = array();//registration idlerimizi tutacak array ı oluşturuyoruz
	if(strcmp($_POST['users'],"All Users") == 0){
		$sql = "SELECT * FROM gcm_user";//Tüm kullanıcı gcm registration idlerini alıcak sql sorgumuz
	}
	else{
		$sql = "SELECT * FROM gcm_user WHERE id=". $_POST['users'];
	}
    
		
   
   $result = mysqli_query($con, $sql);//sorguyu çalıştırıyoruz
   while($row = mysqli_fetch_assoc($result)){
    array_push($registatoin_ids, $row['reg_id']);//databaseden dönen registration idleri $registatoin_ids arrayine atıyoruz
   }
  
   // GCM servicelerine gidecek veri
   //Arkadaşlar aşşağıdaki PHP kodlarıyla oynamıyoruz. Bu Google 'n bizden kullanmamızı istediği kodlar
   //Sadece registration_ids,mesaj ve Authorization: key değerlerini değiştiriyoruz
    $url = 'https://android.googleapis.com/gcm/send';
    
    $mesaj = array("notification_message" => $_POST['mesaj'],"sender" => $_POST['sender']); //gönderdiğimiz mesaj POST 'tan alıyoruz.Androidde okurken notification_message değerini kullanacağız
         $fields = array(
             'registration_ids' => $registatoin_ids,
             'data' => $mesaj,
         );
         
		
		 
		 
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
         //echo $result;
		 echo "<div class=\"col-md-12\"><textarea style=\"resize:none; width:98%; position:absolute\" row=\"4\">".$result."</textarea></div>";
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
								<div class="col-md-10" style="padding-right:1%">
									<select name="users" class="form-control">
										<option name="allUser">All Users</option>
										<?php 
											$sql = "SELECT id FROM gcm_user";
											$result = mysqli_query($con,$sql);
											while ($row = mysqli_fetch_assoc($result)){
												echo "<option value=". $row['id'] ." name=".$row['id'].">" . $row['id'] . "</option>";
												}										
										?>
									</select>
								</div>
								<div class="col-md-2" style="padding:0px">
									<a href="create_group.php" class="btn btn-default" role="button" title="Create group" style="border:0px;width:34px;height:34px;background-image:url(plus.png);background-size: 100% 100%"></a>
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