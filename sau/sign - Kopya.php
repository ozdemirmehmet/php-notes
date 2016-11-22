<html>

<?php
	require_once("connect.php");
	if( isset($_POST["studentId"]) & isset($_POST["major"]) & isset($_POST["minor"]) ){
		header('content-type:text/html;charset=utf-8');
		$studentId = $_POST["studentId"];
		$major = $_POST["major"];
		$minor = $_POST["minor"];

		$sql1 = "SELECT id,name FROM class WHERE major='$major' AND minor='$minor'";
		$result1 = $con->query($sql1);//Burada o gelen major ve minor değerlerşne ait sınıf olup olmadığını kontrol edecek sorguyu çalıştırdık.
		if($result1->num_rows > 0){//Bu major ve minor değerlerine ait sınıf var ise
			$row1 = $result1->fetch_assoc();
			$classId = $row1['id'];
			$className = $row1['name'];

			//İçinde bulunulan saat ve günde o sınıfta hangi dersin olduğunu kontrol edecek sorgumuz
			$sql2 = "SELECT lesson.id FROM lesson INNER JOIN schedule ON lesson.scheduleId=schedule.id WHERE CURRENT_TIME() BETWEEN schedule.startTime AND schedule.endTime AND schedule.day = 'Sali' AND lesson.classId = '$classId'";
			$result2 = $con->query($sql2);
			if($result2->num_rows > 0){//O anda o sınıfta bir ders var ise
				$row2 = $result2->fetch_assoc();
				$lessonId = $row2['id'];

				//Derse ait verilerin alındığı sorgumuz
				$sql = "SELECT lesson.name,lesson.term,instructor.firstName,instructor.lastName,instructor.rank FROM lesson INNER JOIN instructor ON lesson.instructorId=instructor.id WHERE lesson.id = '$lessonId'";
				$result = $con->query($sql);
				$row = $result->fetch_assoc();

				$lessonName = utf8_encode($row['name']);
				$lessonTerm = utf8_encode($row['term']);
				$instructorFirstName = utf8_encode($row['firstName']);
				$instructorLastName = utf8_encode($row['lastName']);
				$instructorRank = utf8_encode($row['rank']);


				//İstekle bereaber gelen öğrenci id sinin kayıtları içerisinde o anda bulunduğu sınıftaki dersin olup olmadığını kontrol edecek sorgumuz
				$sql3 = "SELECT enrollment.id FROM enrollment INNER JOIN student ON enrollment.studentId = student.id WHERE enrollment.lessonId = '$lessonId' AND enrollment.studentId = $studentId";
				$result3 = $con->query($sql3);
				if($result3->num_rows > 0){//Eğer o öğrenci bulunduğu sınıftaki dersi alıyorsa

					//Öğrenci alıdğı bir dersin zamanında derste ise yoklamaya imza attığına dair ilgili kayıdın yapılacağı sorgumuz
					$sql4 = "INSERT INTO attendance (studentId, dateAttented, hours, lessonId) VALUES ('$studentId',CURRENT_DATE(),'1','$lessonId')";
					if(!mysqli_query($con, $sql4)){//kayıt gerçekleşmez ise
  						$response = array(
							"response" => "ERROR_SIGN"
							);	
					}
					else{//Kayıt başarılı
						$response = array(
							"response" => "OK_SIGN",
							"lesson" => array(
								"name" => $lessonName,
								"term" => $lessonTerm,
								"className" => $className,
								"instructor" => array(
									"firstName" => $instructorFirstName,
									"lastName" => $instructorLastName,
									"rank" => $instructorRank
									)
								)
							);	
					}
				}
				else{//Öğrenci bulunduğu sınıftaki dersi almıyorsa
					$response = array(
						"response" => "NO_REGISTERED_LESSON",
						"lesson" => array(
								"name" => $lessonName,
								"term" => $lessonTerm,
								"className" => $className,
								"instructor" => array(
									"firstName" => $instructorFirstName,
									"lastName" => $instructorLastName,
									"rank" => $instructorRank
									)
								)
						);
				}
			}
			else{//O anda o sınıfta ders yok ise
				$response = array(
					"response" => "NO_LESSON"
					);
			}
		}
		else{//Gelen major ve minor değerlerine ait sınıf yok ise
			$response = array(
				"response" => "NO_CLASS"
				);
		}

		echo json_encode($response,JSON_UNESCAPED_UNICODE);
		mysqli_close($con);
		
	}
?>
<body>
	<form action="sign.php" method="post">
  		Student Id: <input type="text" name="studentId"><br>
  		Major: <input type="text" name="major"><br>
  		Minor: <input type="text" name="minor"><br>
  		<input type="submit">
	</form>

</body>
</html>