<?php
error_reporting(E_ALL);

/* Betik sürekli bağlantı beklesin. */
set_time_limit(0);

/* Örtük çıktılama etkin olsun, böylece ne yaptğımızı görürüz. */
ob_implicit_flush();

$adres = '93.184.216.34';
$port = 10000;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create()  basarısız oldu: sebep: " .
          socket_strerror(socket_last_error()) . "\n";
}

if (socket_bind($sock, $adres, $port) === false) {
    echo "socket_bind()  basarisiz oldu: sebep: " .
          socket_strerror(socket_last_error($sock)) . "\n";
}

if (socket_listen($sock, 5) === false) {
    echo "socket_listen()  basarısız oldu: sebep: " .
          socket_strerror(socket_last_error($sock)) . "\n";
}

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept()  basarısız oldu: sebep: " .
              socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }
    /* Komutları gönder. */
    $msg = "\nPHP Deneme Sunucusuna Hoş Geldiniz.\n" .
        "Çıkmak için 'quit', sunucuyu kapatmak için " .
        "'shutdown' yazıp enter tuşuna basınız.\n";
    socket_write($msgsock, $msg, strlen($msg));

    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ)))
        {
            echo "socket_read() başarısız oldu: sebep: " .
                  socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == 'quit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            break 2;
        }
        $talkback = "Şunları yazdınız:'$buf'.\n";
        socket_write($msgsock, $talkback, strlen($talkback));
        echo "$buf\n";
    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);
?>