<?php
define('DB_NAME', 'sau');
/** MySQL veritabanı kullanıcısı */
define('DB_USER', 'root');
/** MySQL veritabanı parolası */
define('DB_PASSWORD', '');
/** MySQL sunucusu */
define('DB_HOST', 'localhost');
/** Yaratılacak tablolar için veritabanı karakter seti. */
define('DB_CHARSET', 'utf8');
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Bağlanırken hata oluştu : " . mysqli_connect_error();
  }

mysqli_set_charset($con, 'utf8');
?>