<html>

<head>
<title>Php Ba�lang��</title>
</head>

<body>

<form method="post" action="yaz.php">

Kullan�c� Ad�<input type="text" name="k_adi"/>
<br>Sifre<input type="text" name="pass"/>
<br><br>Sigara Kullan�m�<br>

Kullan�yorum<input type="radio" name="cigara" value="var"/>
Ara S�ra<input type="radio" name="cigara" value="araara"/>
Kullanm�yorum<input type="radio" name="cigara" value="yok"/>

<br><br>Askerlik<select name="askerlik">
<option value="yapildi">Yap�ld�</option>
<option value="tecilli">Tecilli</option>
<option value="muaf">Muaf</option>
</select>

<br><br>�steklerim
<textarea name="istek" rows="2"></textarea>
<br><br><input type="submit" value="G�nder"/>



</body>

</html>