<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Giriş</title>
</head>


<?php
 
	require_once("connect.php");
	$control = false;
	if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$sql = "SELECT * FROM instructor WHERE instructorNo='$username' AND password='$password'";
		$result = $con->query($sql);
		$sql2 = "SELECT * FROM student WHERE studentNo='$username' AND password='$password'";
		$result2 = $con->query($sql2);
		if($result->num_rows > 0){//Giriş başarılı. Akademik personel girişi yapıldı
			$row = $result->fetch_assoc();
			$instructorId = $row['id'];
			$imageId = $row['imageId'];
			
			header("Location: instructor.php?instructorId=$instructorId&imageId=$imageId");
		}
		else if($result2->num_rows > 0){//Giriş başarılı. Öğrenci girişi yapıldı.
			$row2 = $result2->fetch_assoc();
			$studentId = $row2['id'];
			$imageId = 0;
			header("Location: student1.php?studentId=$studentId&imageId=$imageId");
		}
		else{//Hatalı giriş
			$control = true;
		}
	}
?>
  


<style>
	html,body{
		background-color:#F0F0F0;
	}
</style>
<body>
	<div class="col-md-12" style="padding:6%"></div>
	<form class="form" method="post" action="sabisLogin.php">
		<div class="container">
			<div class="row">
				<div class="col-md-3" style="padding-top:0.3%"></div>
				<div class="col-md-6" style="padding-top:0.3%">
					<div class="col-md-1"></div>
					<div class="col-md-10" style="border-radius:5px; border:1px solid; background-color:#FFFFFF; padding:4%">
						<div class="form-group">
							<?php
								if($control){
									echo "<div class=\"col-md-12\" style=\"padding:1%\">";
									echo "<p class=\"bg-danger\" style=\"border:1px solid; border-color:#F29797; color:#AA1515; padding:3%\">Hatalı Giriş</p>";
									echo "</div>";
								}
							?>
							<div class="col-md-12">
								<h4 style="font-weight:bold" align="center">Devam Takip Sistemi Giriş</h4>
							</div>
							<div class="col-md-1" style="padding:2%"></div>
							<div class="col-md-10" style="border:0.2px solid; background-color:#FFFFFF"></div>
							<div class="col-md-1 style="padding:2%""></div>
							<div class="col-md-1"></div>
							<div class="col-md-10" style="padding:2%">
								<input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı Adı" style="margin-top:5%">
								<input type="password" class="form-control" id="password" name="password" placeholder="Şifre" style="margin-top:5%">
								<input id="submit" type="submit" name="submit" value="Giriş" class="btn btn-primary" style="float:right; margin-top:5%"/>
							</div>
							<div class="col-md-1"></div>
						</div>
						<div class="col-md-12" style="height:2%" ></div>
					</div>	
					<div class="col-md-1"></div>
				</div>
				<div class="col-md-3" style="padding-top:0.3%"></div>
			</div>
		</div>
	</form>
</body>
</html>