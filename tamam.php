<?php
ob_start();
require_once 'ayarlar.php';
require_once 'fonksiyonlar.php';
require_once 'ust.php';

$id = $_GET['id'];

if (!preg_match("/^[a-z0-9]{32}$/", $id)) {
    header("Location: index.php");
    exit();
}

vt_baglan();

$vt_sonuc = mysql_query("SELECT * FROM katilimcilar WHERE MD5(CONCAT(id, eposta)) = '$id'") or vt_hata();

if (mysql_num_rows($vt_sonuc) == 0) {
    header("Location: index.php");
    exit();
}

$vt_satir = array_map("stripslashes", mysql_fetch_assoc($vt_sonuc));
extract($vt_satir, EXTR_OVERWRITE);
?>

<p>Sayın <?php echo $ad . " " . $soyad; ?>,</p>
<p><strong><?php echo $kurslar[$kurs]; ?></strong> kursuna <strong><?php echo $id; ?></strong> numarası ile kaydınız alınmıştır.</p>
<p><?php echo SITE_AD; ?><br><?php echo SITE_ADRES; ?></p>

<?php
require_once 'alt.php';
ob_end_flush();
?>
