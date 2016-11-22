<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Ana Sayfa</title>
</head>
<?php
	require_once("connect.php");
	if(isset($_GET['studentId']) && isset($_GET['imageId'])){
		$id = $_GET['studentId'];
		$imageId = $_GET['imageId'];
	}
	else{
		header("Location: sabisLogin.php");
	}
?>


<style>
	html,body{
		background-color:#F0F0F0;
	}
</style>
<body>
	<div class="container" style="border-radius:5px; border:1px solid; background-color:#FFFFFF; padding:2%; padding-top:1%">
		<div class="col-md-12" style="padding:1%">
			<h3 style="font-weight:bold">Devam Takip Sistemi</h3>
			<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
		</div>
		<div class="col-md-12">
			<div class="col-md-2">
				<?php
					echo "<img src=\"photos/".$imageId.".jpg\"></img>";
				?>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-9" style="padding:1%">
				<label>Öğrenci Bilgileri</label>
				<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
				<div class="col-md-3" style="padding:0.2%">
					<h4>Öğrenci No<h4>
					<h4>Adı</h4>
					<h4>Fakültesi</h4>
					<h4>Bölümü</h4>
				</div>
				<div class="col-md-9" style="padding:0.2%">
					<?php
						$sql ="SELECT * FROM student WHERE id='$id'";
						$result = $con->query($sql);
						$row = $result->fetch_assoc();
						//$imageId = $row['imageId'];
						echo "<div class=\"col-md-12\" style=\"padding:0.5%\">";
						echo "<h4>: ".$row['studentNo']."</h4>";
						echo "<h4>: ".$row['firstName']." ".$row['lastName']."</h4>";
						echo "<h4>: ".$row['faculty']."</h4>";
						echo "<h4>: ".$row['department']."</h4>";
						echo "</div>";
					?>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="padding:2%">
			<label>Seçilen Dersler</label>
			<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
			<table class="table table-striped" style="margin-top:1%">
   				<thead>
    				<tr>
       					<th>Ders Adı</th>
       					<th>Yarıyılı</th>
       					<th>Gün</th>
       					<th>Saat</th>
       					<th>Sınıfı</th>
    				</tr>
    			</thead>
    			<tbody>
    				<?php
    					$sql = "SELECT lesson.id,lesson.lessonName,lesson.term,schedule.day,schedule.startTime,schedule.endTime,class.name FROM lesson INNER JOIN schedule 
    					ON lesson.scheduleId=schedule.id INNER JOIN class ON lesson.classId=class.id INNER JOIN enrollment ON enrollment.lessonId=lesson.id WHERE enrollment.studentId='$id'";
    					$result = $con->query($sql);
    					while($row = $result->fetch_assoc()){
    						echo "<tr>";
    						echo "<td><a href=\"lesson1.php?studentId=".$id."&lessonId=".$row['id']."\">".$row['lessonName']."</a></td>";
    						echo "<td>".$row['term']."</td>";
    						echo "<td>".$row['day']."</td>";
    						echo "<td>".$row['startTime']."-".$row['endTime']."</td>";
    						echo "<td>".$row['name']."</td>";
    						echo "</tr>";
    					}
    				?>
    			</tbody>
  			</table>
		</div>
	</div>
</body>
</html>