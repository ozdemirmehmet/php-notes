<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Create Group</title>
</head>
<?php
	require_once("baglan.php");
	if(isset($_POST['submit'])){
		if(isset($_POST['checkedContacts'])){
			if(count($_POST['checkedContacts']) < 2){
				echo "<script>alert(\"Lütfen en az 2 kişiyi seçiniz!\")</script>";
			}
			else if(strcmp($_POST['group_name'],"") == 0){
				echo "<script>alert(\"Lütfen bir grup adı belirleyiniz!\")</script>";
			}
			else{
				$name = $_POST['group_name'];
				$sql = "INSERT INTO gcm_message_group (group_name) VALUES ('$name')";
				$con->query($sql);
				$sql = "SELECT id FROM gcm_message_group ORDER BY id DESC LIMIT 1";
				$result = $con->query($sql);
				$row = $result->fetch_array();
				$id = $row["id"];
				$checkedlist = $_POST['checkedContacts'];
				$number = count($checkedlist);
				for($i=0;$i<$number;$i++){
					$sql2 = "INSERT INTO gcm_mes_group_users (group_id,user_id) VALUES ('$id','$checkedlist[$i]')";
					$con->query($sql2);
				}
			}
		}
		else
			echo "<script>alert(\"Lütfen en az 2 kişiyi seçiniz!\")</script>";
	}

?>




<style>
	html,body{
		background-color:#F0F0F0;
	}
</style>
<body>
	<div class="col-md-12" style="padding:4%"></div>
	<form class="form" method="post" action="create_group.php">
		<div class="container">
			<div class="col-md-1"></div>
			<div class="col-md-10" style="text-align:center;padding-top:1%">
				<label>Select the contacts you want to add to the group</label>
			</div>
			<div class="row" style="border:1px solid;border-radius:5px;padding:2%;padding-top:4%;background-color:#FFFFFF">
				<div class="col-md-1"></div>
				<div class="col-md-10" style="border:1px solid; border-radius:5px;max-height:45%; overflow:auto">
				<?php
					$sql = "SELECT * FROM gcm_user";
					$result = mysqli_query($con,$sql);
					while($row = mysqli_fetch_assoc($result)){
						echo "<div class=\"col-md-3\" style=\"padding:0.2%\" >";
						echo "<label style=\"cursor:pointer\"><input type=\"checkbox\" name=\"checkedContacts[]\" value=". $row['id']."/> ".$row['id']."</label>";
						echo "</div>";
					}
				?>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-12" style="padding:0px;margin-top:1.5%">
				<div class="col-md-1"></div>
				<div class="col-md-1" style="padding-left:0px">
					<label for="group_name" style="font-size:14pt">Name</label>
				</div>
				<div class="col-md-8" style="padding:0px">
					<input type="text" name ="group_name" id="group_name" placeholder="Type group name..." class="form-control"/>
				</div>
				<div class="col-md-1" style="padding:0px">
					<input type="submit" name="submit" value="Create" class="btn btn-success" style="float:right"></input>
				</div>
				<div class="col-md-1"></div>
				</div>
			</div>
		</div>
	</form>
</body>
</html>