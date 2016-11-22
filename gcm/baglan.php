<?php

define('DB_NAME','android');

define('DB_USER','root');

define('DB_PASSWORD','');

define('DB_HOST','localhost');

define('DB_CHARSET','utf8');

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(mysqli_connect_errno()){
	echo "Baglanirken hata olustu ".mysqli_connect_errno();
}

?>