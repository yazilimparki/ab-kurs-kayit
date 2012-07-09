<?php
ob_start();
require_once 'ayarlar.php';
require_once 'fonksiyonlar.php';

if ($_SERVER['PHP_AUTH_USER'] != YONETICI_KULLANICI && $_SERVER['PHP_AUTH_PW'] != YONETICI_PAROLA) {
    header("WWW-Authenticate: Basic realm=\"" . SITE_AD . "\"");
    header("HTTP/1.0 401 Unauthorized");
    echo "Hatali giris. <a href=\"{$_SERVER['SCRIPT_NAME']}\">Tekrar deneyin.</a>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo SITE_AD; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="kurs-kayit.css">
</head>
<body>

<?php
$kurs  = (integer) $_POST['kurs'];
$alan  = (array) $_POST['alan'];
$cikti = (integer) $_POST['cikti'];

if (count($alan) == 0) {
    $alan = array(
        'ad' => 1,
        'soyad' => 1,
        'unvan' => 1,
        'kurum' => 1,
        'eposta' => 1,
        'telefon' => 1,
        'kurs' => 1,
        'kayit_tarihi' => 1
    );
}

$vt_komut = "";

if ($kurs > 0) {
    $vt_komut = " AND kurs = '$kurs'";
}

if (!isset($cikti)) {
    $cikti = 0;
}
?>

<script type="text/javascript">
function tumunu_sec() {
    var f = document.forms[0];

    for (var i = 0; i < f.elements.length; i++) {
        if (f.elements[i].name.indexOf('alan[') == 0) {
            f.elements[i].checked = true;
        }
    }
}
</script>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>"> 
<div class="alan">
<label for="kurs">Kurs:</label>
<select name="kurs" size="1">
<option value="">Tümü</option>
<?php foreach ($kurslar as $key => $value) {
    echo "<option value=\"$key\"" . (($kurs == $key) ? " selected" : "") . ">$value</option>\n";
}
?>
</select>
</div>
<div class="alan">
<label for="alan">Listelenecek Alanlar:</label>
<table border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td nowrap>
<a href="javascript:void(0);" onclick="tumunu_sec();">Tümü</a><br>
<input type="checkbox" name="alan[no]" value="1"<?php echo (($alan['no'] == 1) ? " checked" : ""); ?>> Kayıt No<br>
<input type="checkbox" name="alan[ad]" value="1"<?php echo (($alan['ad'] == 1) ? " checked" : ""); ?>> Ad<br>
<input type="checkbox" name="alan[soyad]" value="1"<?php echo (($alan['soyad'] == 1) ? " checked" : ""); ?>> Soyad<br>
<input type="checkbox" name="alan[unvan]" value="1"<?php echo (($alan['unvan'] == 1) ? " checked" : ""); ?>> Unvan<br> 
</td> 
<td nowrap>
<input type="checkbox" name="alan[kurum]" value="1"<?php echo (($alan['kurum'] == 1) ? " checked" : ""); ?>> Kurum<br>
<input type="checkbox" name="alan[eposta]" value="1"<?php echo (($alan['eposta'] == 1) ? " checked" : ""); ?>> E-Posta Adresi<br>
<input type="checkbox" name="alan[telefon]" value="1"<?php echo (($alan['telefon'] == 1) ? " checked" : ""); ?>> Cep Telefonu Numarası<br>
<input type="checkbox" name="alan[kurs]" value="1"<?php echo (($alan['kurs'] == 1) ? " checked" : ""); ?>> Kurs<br>
<input type="checkbox" name="alan[kayit_tarihi]" value="1"<?php echo (($alan['kayit_tarihi'] == 1) ? " checked" : ""); ?>> Kayıt Tarihi<br>
</td>
</tr>
</table>
</div>
<div class="alan">
<label for="cikti">Çıktı Türü:</label>
<input type="radio" name="cikti" value="0"<?php echo (($cikti == 0) ? " checked" : ""); ?>> Tablo (HTML)
<input type="radio" name="cikti" value="1"<?php echo (($cikti == 1) ? " checked" : ""); ?>> Metin (Text)
</div>
<div class="alan">
<input type="submit" value="Listele">
</div>
</form>

<?php
vt_baglan();
$vt_sonuc = mysql_query("SELECT * FROM katilimcilar WHERE 1 $vt_komut ORDER BY kayit_tarihi DESC") or vt_hata();
$vt_sayi = mysql_num_rows($vt_sonuc);

echo "<p>Toplam <strong>$vt_sayi</strong> kayıt.</p>\n";

if ($cikti == 0) {
    echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"3\" width=\"100%\">\n" .
         "<tr>\n" .
         (($alan['no'] == 1) ? "<th>NO</th>\n" : "") .
         (($alan['ad'] == 1) ? "<th>AD</th>\n" : "") .
         (($alan['soyad'] == 1) ? "<th>SOYAD</th>\n" : "") .
         (($alan['unvan'] == 1) ? "<th>UNVAN</th>\n" : "") .
         (($alan['kurum'] == 1) ? "<th>KURUM</th>\n" : "") .
         (($alan['eposta'] == 1) ? "<th>E-POSTA</th>\n" : "") .
         (($alan['telefon'] == 1) ? "<th>TELEFON</th>\n" : "") .
         (($alan['kurs'] == 1) ? "<th>KURS</th>\n" : "") .
         (($alan['kayit_tarihi'] == 1) ? "<th>KAYIT TARİHİ</th>\n" : "") .
         "</tr>\n";
}
else {
    echo "<pre>\n";
}

while ($vt_satir = mysql_fetch_assoc($vt_sonuc)) {
    $vt_satir = array_map("stripslashes", $vt_satir);
    extract($vt_satir, EXTR_OVERWRITE|EXTR_PREFIX_ALL, "k");

    $satir = "<tr>" .
         (($alan['no'] == 1) ? "<td>$k_id</td>" : "") .
         (($alan['ad'] == 1) ? "<td>$k_ad</td>" : "") .
         (($alan['soyad'] == 1) ? "<td>$k_soyad</td>" : "") .
         (($alan['unvan'] == 1) ? "<td>$k_unvan</td>" : "") .
         (($alan['kurum'] == 1) ? "<td>$k_kurum</td>" : "") .
         (($alan['eposta'] == 1) ? "<td>$k_eposta</td>" : "") .
         (($alan['telefon'] == 1) ? "<td>$k_telefon</td>" : "") .
         (($alan['kurs'] == 1) ? "<td>{$kurslar[$k_kurs]}</td>" : "") .
         (($alan['kayit_tarihi'] == 1) ? "<td>$k_kayit_tarihi</td>" : "") .
         "</tr>\n";

    if ($cikti == 1) {
        $satir = preg_replace("/<\/td>/", "|", $satir);
        $satir = html_entity_decode(strip_tags($satir));
        $satir = substr($satir, 0, -2) . "\n";
    }

    echo $satir;
}

echo ($cikti == 0) ? "</table>" : "</pre>";
?>

</body>
</html>
