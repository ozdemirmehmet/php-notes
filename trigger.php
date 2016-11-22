<?php

if($_POST){
	
	$baglanti=fopen("yeni.txt","a+");
if(fputs($baglanti,"kisi eklendi")){
	echo "veri kaydedildi";
	
}
else{
echo "hata";
}
fclose($baglanti);
	
}


?>