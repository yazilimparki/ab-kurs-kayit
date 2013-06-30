<?php
ob_start();
require_once 'ayarlar.php';
require_once 'fonksiyonlar.php';
require_once 'ust.php';

if (!empty($_POST)) {
    vt_baglan();

    $_POST_suzulmus = $_POST;
    array_walk_recursive($_POST_suzulmus, "giris_suz");
    extract($_POST_suzulmus, EXTR_OVERWRITE);

    $_HATA = array();

    if (empty($ad)) {
        $_HATA[] = "Lütfen adınızı giriniz.";
    }
    if (empty($soyad)) {
        $_HATA[] = "Lütfen soyadınızı giriniz.";
    }
    if (empty($kurum)) {
        $_HATA[] = "Lütfen kurumunuzu giriniz.";
    }
    if (empty($eposta)) {
        $_HATA[] = "Lütfen e-posta adresinizi giriniz.";
    }
    else if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $eposta)) {
        $_HATA[] = "Lütfen geçerli bir e-posta adresi giriniz.";
    }
    else {
        $vt_sonuc = mysql_query("SELECT COUNT(*) FROM katilimcilar WHERE LOWER(eposta) = LOWER('$eposta')") or vt_hata();

        if ((integer) mysql_result($vt_sonuc, 0) > 0) {
            $_HATA[] = "Bu e-posta adresi ile daha önce kurs kaydınız bulunmaktadır. " . SITE_AD . " süresince sadece bir kursa kayıt yaptırabilirsiniz.";
        }
    }

    if (empty($telefon)) {
        $_HATA[] = "Lütfen cep telefonu numaranızı giriniz.";
    }
    if (empty($kurs)) {
        $_HATA[] = "Lütfen katılmak istediğiniz kursu seçiniz.";
    }

    if (count($_HATA) > 0) {
        echo "<div class=\"hata\"><ul>\n";

        foreach ($_HATA as $value) {
            echo "<li>$value</li>\n";
        }

        echo "</ul></div>\n";
    }
    else {
        mysql_query("INSERT INTO katilimcilar (ad, soyad, unvan, kurum, eposta, telefon, kurs, kayit_tarihi) VALUES ('$ad', '$soyad', '$unvan', '$kurum', '$eposta', '$telefon', '$kurs', NOW())") or vt_hata();
        $id = mysql_insert_id();

        $mesaj = "Sayın $ad $soyad,\n\n" .
            "\"" . $kurslar[$kurs] . "\" kursuna \"$id\" numarası ile kaydınız alınmıştır.\n\n" .
            SITE_AD . "\n" . 
            SITE_ADRES;

        eposta_gonder($eposta, "", $mesaj);
        header("Location: tamam.php?id=" . md5($id . $eposta));
        exit();
    }
}
?>

<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
<div class="alan">
<label for="ad">Adınız:</label>
<input type="text" name="ad" size="30" maxlength="50" value="<?php echo $ad; ?>">
</div>
<div class="alan">
<label for="soyad">Soyadınız:</label>
<input type="text" name="soyad" size="30" maxlength="50" value="<?php echo $soyad; ?>">
</div>
<div class="alan">
<label for="unvan">Unvanınız:</label>
<input type="text" name="unvan" size="30" maxlength="50" value="<?php echo $unvan; ?>">
</div>
<div class="alan">
<label for="kurum">Kurum:</label>
<input type="text" name="kurum" size="30" maxlength="150" value="<?php echo $kurum; ?>">
</div>
<div class="alan">
<label for="eposta">E-Posta Adresiniz:</label>
<input type="text" name="eposta" size="30" maxlength="150" value="<?php echo $eposta; ?>">
</div>
<div class="alan">
<label for="telefon">Cep Telefonu Numaranız:</label>
<input type="text" name="telefon" size="30" maxlength="15" value="<?php echo $telefon; ?>">
</div>
<div class="alan">
<label for="kurs">Katılmak İstediğiniz Kurs:</label>
<?php
foreach ($kurslar as $key => $value) {
    echo "<input type=\"radio\" name=\"kurs\" value=\"$key\"" . (($kurs == $key) ? " checked" : "") . "> $value<br>\n";
}
?>
</div>
<div class="alan">
<input type="submit" value="Kayıt Ol">
</div>
</form>

<?php
require_once 'alt.php';
ob_end_flush();
?>
