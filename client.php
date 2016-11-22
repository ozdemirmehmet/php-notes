<?php
error_reporting(E_ALL);

echo "<h2>TCP/IP bağlantısı</h2>\n";

/* WWW hizmeti için port isteyelim. */
$service_port = getservbyname('www', 'tcp');

/* Hedef konağın IP adresini alalım. */
$adres = gethostbyname('www.example.com');

/* Bir TCP/IP soketi oluşturalım. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "\nsocket_create() başarısız oldu: sebep: " .
          socket_strerror(socket_last_error()) . "\n";
} else {
    echo "\nTamam.\n";
}

echo "\n'$adres' adresine '$service_port' üzerinden bağlanmaya çalışılıyor...";
$result = socket_connect($socket, $adres, $service_port);
if ($result === false) {
    echo "\nsocket_connect() başarısız oldu.\nSebep: ($result) " .
          socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "\nTamam.\n";
}

$in = "HEAD / HTTP/1.1\r\n";
$in .= "Host: www.example.com\r\n";
$in .= "Connection: Close\r\n\r\n";
$out = '';

echo "\nHTTP HEAD isteği gönderiliyor...";
socket_write($socket, $in, strlen($in));
echo "\nTamam.\n";

echo "\nAlınan yanıt:\n\n";
while ($out = socket_read($socket, 2048)) {
    echo $out;
}

echo "\nSoket kapatılıyor...";
socket_close($socket);
echo "\nTamam.\n\n";
?>