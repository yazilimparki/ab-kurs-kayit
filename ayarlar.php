<?php
define('DEBUG', true); // SQL hatalarini ekrana bastirmak icin.

define('VT_ADRES',     'localhost');
define('VT_KULLANICI', 'ab');
define('VT_PAROLA',    'demo');
define('VT_AD',        'ab_kurs_kayit');

define('SITE_AD',    'Akademik Bilişim 201X');
define('SITE_ADRES', 'http://ab.org.tr');

define('POSTA_ADRES', 'bilgi@ab.org.tr');
define('POSTA_ISIM',  'Akademik Bilişim 201X');

define('YONETICI_KULLANICI', 'ab');
define('YONETICI_PAROLA',    'demo');

$kurslar = array(
    1 => 'Güvenlik',
    2 => 'Linux Sistem Yönetimi',
    3 => 'Python',
    4 => 'PostgreSQL Veritabanı Yönetimi',
    5 => 'LibreOffice/OpenOffice',
    6 => 'Android',
    7 => 'PHP'
);

error_reporting(E_ALL ^ E_NOTICE);
?>
