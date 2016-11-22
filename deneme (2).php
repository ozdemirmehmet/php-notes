<html>

<head>
<title>Php Baþlangýç</title>
</head>

<body>

<form method="post" action="yaz.php">

Kullanýcý Adý<input type="text" name="k_adi"/>
<br>Sifre<input type="text" name="pass"/>
<br><br>Sigara Kullanýmý<br>

Kullanýyorum<input type="radio" name="cigara" value="var"/>
Ara Sýra<input type="radio" name="cigara" value="araara"/>
Kullanmýyorum<input type="radio" name="cigara" value="yok"/>

<br><br>Askerlik<select name="askerlik">
<option value="yapildi">Yapýldý</option>
<option value="tecilli">Tecilli</option>
<option value="muaf">Muaf</option>
</select>

<br><br>Ýsteklerim
<textarea name="istek" rows="2"></textarea>
<br><br><input type="submit" value="Gönder"/>



</body>

</html>