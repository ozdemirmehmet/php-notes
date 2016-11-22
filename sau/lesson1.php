<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Ders</title>

	<style type="text/css">
		.table td {
   			text-align: center;   
		}
		.table th {
   			text-align: center;   
		}
	</style>
</head>
<?php
	require_once("connect.php");
	if(isset($_GET['lessonId']) && isset($_GET['studentId'])){
		$lessonId = $_GET['lessonId'];
		$studentId = $_GET['studentId'];

		$totalHours = 0;
		$sql = "SELECT TIMESTAMPDIFF(HOUR, startTime, endTime) AS lessonHours,schedule.startTime,schedule.dayName FROM schedule 
       			INNER JOIN lesson ON schedule.id=lesson.scheduleId WHERE lesson.id='$lessonId'";
       	$result = $con->query($sql);
       	$row = $result->fetch_assoc();
       	$day = $row['dayName'];
       	$startTime = $row['startTime']+1-1;
       	$lessonHours = $row['lessonHours'];

		$startdate=strtotime("next $day",strtotime("22 February 16"));
		$enddate=strtotime(date("Y-m-d"));
		while($startdate < $enddate){
			$totalHours += $lessonHours;
   			$startdate = strtotime("+1 week", $startdate);
		}
		$startdate=strtotime("next $day",strtotime("22 February 16"));
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
	<div class="container" style="border-radius:5px; border:1px solid; background-color:#FFFFFF;padding:2%; padding-top:1%">
		<div class="col-md-12" style="padding:1%">
			<h3 style="font-weight:bold">Devam Takip Sistemi</h3>
			<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
		</div>
		<div class="col-md-12" style="padding:0.5%">
			<div class="col-md-8" style="padding:1%">
				<div class="col-md-12" style="padding:0%">
					<label>Ders Bilgileri</label>
				</div>
				<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
				<div class="col-md-4" style="padding:0.2%">
					<h4>Adı</h4>
					<h4>Öğretim Görevlisi</h4>
					<h4>Yarıyıl</h4>
					<h4>Gün</h4>
					<h4>Saat</h4>
					<h4>Sınıf</h4>
					<h4>Genel Katılım Yüzdesi</h4>
				</div>
				<div class="col-md-8" style="padding:0.2%">
					<?php
						$sql = "SELECT * FROM lesson INNER JOIN schedule ON lesson.scheduleId=schedule.id INNER JOIN class ON lesson.classId=class.id 
						INNER JOIN instructor ON lesson.instructorId=instructor.id WHERE lesson.id='$lessonId'";
						$result = $con->query($sql);
						$row = $result->fetch_assoc();
						echo "<h4>: ".$row['lessonName']."</h4>";
						echo "<h4>: ".$row['rank']." ".$row['firstName']." ".$row['lastName']."</h4>";
						echo "<h4>: ".$row['term']."</h4>";
						echo "<h4>: ".$row['day']."</h4>";
						echo "<h4>: ".$row['startTime']." - ".$row['endTime']."</h4>";
						echo "<h4>: ".$row['name']."</h4>";
						$sql1 = "SELECT COUNT(attendance.id) AS count FROM attendance INNER JOIN attendance_hours ON 
							attendance_hours.attendanceId =attendance.id WHERE attendance.studentId='$studentId' AND attendance.lessonId='$lessonId'";
    					$result1 = $con->query($sql1);
    					$row1 = $result1->fetch_assoc();
    					$totalAttendtedHours = $row1['count'];
						$rank = ($totalAttendtedHours*100)/$totalHours;
						echo "<h4>: % ".round($rank,2)."</h4>";
					?>
				</div>
			</div>
			<div class="col-md-4" style="padding:1%">
				<div class="col-md-12" style="padding:0%">
					<label>Ders Açıklaması</label>
					<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
				</div>
				<div class="col-md-12" style="padding:0.2%">
					<?php
						echo "<h5>".$row['description']."</h5>";
					?>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="padding:2%">
			<label>Detaylı Katılım Dökümü</label>
			<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
			<table class="table table-striped" style="margin-top:1%">
   				<thead>
    				<tr>
    					<th>Hafta</th>
       					<th>Tarih</th>
       					<?php
       						for ($hour=1 ; $hour <= $lessonHours ; $hour++){
								echo "<th>".$hour.".Saat</th>";
							}
							echo "<th>H.K.Y.*</th>";
       					?>
    				</tr>
    			</thead>
    			<tbody>
    				<?php
						
						$week = 0;
						$tempStartTime = $startTime;
    					$sql = "SELECT * FROM attendance WHERE studentId='$studentId' AND lessonId='$lessonId'";
    					$result = $con->query($sql);
						$row = $result->fetch_assoc();
						
						while ($startdate <  $enddate) {
							$week++;
							$weeklyAttentedHours = 0;
							$date = date("Y-m-d", $startdate);
							echo "<tr>";
							echo "<td>$week</td>";
    						echo "<td>".$date."</td>";
							$dateAttented = $row['dateAttented'];
							
							if($date == $dateAttented){
								$sql2 = "SELECT hour FROM attendance_hours WHERE attendanceId=".$row['id'];
    							$result2 = $con->query($sql2);
    							$startTime = $tempStartTime;
    							$tempVariable = "";
    							$row2 = $result2->fetch_assoc();
    							for ($hour=1 ; $hour <= $lessonHours ; $hour++){
    								if($startTime == ($row2['hour'])+1-1){
    									$tempVariable = "Var";
    									$row2 = $result2->fetch_assoc();
    									$weeklyAttentedHours++;
    								}
    								else{
    									$tempVariable = "Yok";
    								}    					
    								echo "<td>".$tempVariable."</td>";	
    								$startTime++;
    							}
    							//$totalAttendtedHours += $weeklyAttentedHours;
    							$rate = ($weeklyAttentedHours*100)/$lessonHours;
    							echo "<td>% ".round($rate,2)."</td>";
							$row = $result->fetch_assoc();

							}else { 
								for($hour=1; $hour<=$lessonHours;$hour++){
									echo "<td>Yok</td>";
								}
								echo "<td>% 0</td>";
							}
							echo "</tr>";

   							$startdate = strtotime("+1 week", $startdate);
						}
    				?>
    			</tbody>
  			</table>
  			<div class="col-md-12" style="padding:0px">* Haftalık Katılım Yüzdesi</div>
		</div>
	</div>
</body>
</html>