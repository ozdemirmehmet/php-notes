<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css"/>
	<title>Ders</title>
</head>
<?php
	require_once("connect.php");
	if(isset($_GET['lessonId'])){
		$lessonId = $_GET['lessonId'];
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
					<h4>Hafta Durumu</h4>
				</div>
				<div class="col-md-8" style="padding:0.2%">
					<?php
						$sql = "SELECT * FROM lesson INNER JOIN schedule ON lesson.scheduleId=schedule.id INNER JOIN class ON lesson.classId=class.id 
						INNER JOIN instructor ON lesson.instructorId=instructor.id WHERE lesson.id='$lessonId'";
						$result = $con->query($sql);
						$row = $result->fetch_assoc();

						$startTime = $row['startTime'];
						$endTime = $row['endTime'];
						$lessonHours = ($endTime+1-1)-($startTime+1-1);
						
						$totalHours = 0;
						$startdate=strtotime("next ".$row['dayName'],strtotime("22 February 16"));
						$enddate=strtotime(date("Y-m-d"));
		
						while($startdate < $enddate){
							$totalHours += $lessonHours;
   							$startdate = strtotime("+1 week", $startdate);
						}	

						$week = $totalHours/$lessonHours;

						echo "<h4>: ".$row['lessonName']."</h4>";
						echo "<h4>: ".$row['rank']." ".$row['firstName']." ".$row['lastName']."</h4>";
						echo "<h4>: ".$row['term']."</h4>";
						echo "<h4>: ".$row['day']."</h4>";
						echo "<h4>: ".$startTime." - ".$endTime."</h4>";
						echo "<h4>: ".$row['name']."</h4>";
						echo "<h4>: ".$week." / 14</h4>";
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
			<label>Dersi Alan Öğrenciler</label>
			<div class="col-md-12" style="border:0.2px solid; background-color:#FFFFFF"></div>
			<table class="table table-striped" style="margin-top:1%">
   				<thead>
   					<tr>
   						<th>Öğrenci No</th>
        				<th>Öğrenci Adı</th>
        				<th>Katılım Durumu</th>
      				</tr>
    			</thead>
    			<tbody>
    				<?php
    					$sql = "SELECT student.id,student.studentNo,student.firstName,student.lastName FROM student 
    					INNER JOIN enrollment ON student.id = enrollment.studentId WHERE enrollment.lessonId='$lessonId'";
    					$result = $con->query($sql);
    					while($row = $result->fetch_assoc()){
    						echo "<tr>";
    						echo "<td><a href=\"student.php?studentId=".$row['id']."&lessonId=".$lessonId."\">".$row['studentNo']."</a></td>";
    						echo "<td>".$row['firstName']." ".$row['lastName']."</td>";
    						/*$sql1 = "SELECT COUNT(id) FROM attendance WHERE studentId=".$row['id']." AND lessonId='$lessonId'";
    						$result1 = $con->query($sql1);
    						$row1 = $result1->fetch_assoc();
    						echo "<td>".$row1['COUNT(id)']." / 14</td>";
    						*/
							$sql1 = "SELECT COUNT(attendance.id) AS count FROM attendance INNER JOIN attendance_hours ON 
								attendance_hours.attendanceId =attendance.id WHERE attendance.studentId=".$row['id']." AND attendance.lessonId='$lessonId'";
    						$result1 = $con->query($sql1);
    						$row1 = $result1->fetch_assoc();
    						$totalAttendtedHours = $row1['count'];
							$rank = ($totalAttendtedHours*100)/$totalHours;
							echo "<td> % ".round($rank,2)."</td>";
    						echo "</tr>";
    					}
    				?>
    			</tbody>
  			</table>
		</div>
	</div>
</body>
</html>