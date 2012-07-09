DROP TABLE IF EXISTS `katilimcilar`;
CREATE TABLE `katilimcilar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `soyad` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `unvan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `kurum` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `eposta` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `telefon` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `kurs` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `kayit_tarihi` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
