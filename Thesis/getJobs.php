<?php 
	require_once("connect.php");//veritabanı bağlantısı
	header('content-type:text/html;charset=utf-8');
	if (isset($_GET["date"])) { //Kontrol
 		//POST ile gelen verileri aldık
 		$date = $_GET['date'];
 		$date1 = date("Y-m-d" , strtotime($date . "+1 days"));

		$sql = "SELECT * FROM jobs WHERE job_date BETWEEN '$date' AND '$date1'";
		$result = $con->query($sql);
		if($result->num_rows > 0){
			$response3 = array();
			while($row = $result->fetch_assoc()){
			
				$response2 = array(
						"name" => $row['job_name'],
						"fee" => $row['job_fee']
					);

				array_push($response3, $response2);
			}

			$response = array(
				"response" => "OK",
				"jobs" => $response3
				);
		} else {//İş yok
		$response = array(
				"response" => "NO JOB"
			);
		}
		echo json_encode($response);
		mysqli_close($con);//veritabanı bağlantısı kapatıldı
	}
?>