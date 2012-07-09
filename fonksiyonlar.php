<?php
function vt_hata() {
    die("Veritabanında bir hata oluştu." . (DEBUG ? "<br>SQL Hatası: " . mysql_error() : ""));
}

function vt_baglan() {
    mysql_connect(VT_ADRES, VT_KULLANICI, VT_PAROLA) or vt_hata();
    mysql_select_db(VT_AD) or vt_hata();
    mysql_query("SET NAMES 'utf8'");
}

function eposta_gonder($kime, $konu, $mesaj) {
    mail($kime, $konu, $mesaj, "From: " . POSTA_ISIM . " <" . POSTA_ADRES . ">\nContent-Type: text/plain; charset=utf-8\r\n");
}

function giris_suz(&$deger, $anahtar) {
    $deger = trim(mysql_real_escape_string(htmlspecialchars($deger)));
}
?>
