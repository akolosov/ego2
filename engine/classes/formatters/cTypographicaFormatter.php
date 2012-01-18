<?php
//
// cTypographicaFormatter v0.1a
//
// Класс для типографической коррекции русского текста
// Полная поддержка UTF8
//
// (C)opyLeft & (C)odeRight Alexey Kolosov aka huNTer <alexey.kolosov@mail.ru>
//
// "cTypographicaFormatter" released without warranty under the terms of the Artistic License.
// http://www.opensource.org/licenses/artistic-license.php
//
// $Id: cTypographicaFormatter.php,v 1.1 2005/05/11 07:36:57 hunter Exp $
//

class cTypographicaFormatter {

    private	$useSoftHyphen = false; // использовать "мягкие" переносы по правилам русского языка
    private	$usePhoneCorrection = false; // корректировать номера телефонов
    private	$useWackoWikiCompatible = false; // совместимость с WackoFormatter'ом
    
    function cTypographicaFormatter($useSHy = false, $usePhones = false, $useWackoWiki = false) {
        $this->useSoftHyphen = $useSHy;
	$this->usePhoneCorrection = $usePhones;
	$this->useWackoWikiCompatible = $useWackoWiki;
    }

    function Correction($str) {
	$phonemasks = array( // from Typografica (C) Pixel Apes
                        array(
                              "/([0-9]{4})\-([0-9]{2})\-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/s",
                              "/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/s",
                              "/(\([0-9\+\-]+\)) ?([0-9]{3})\-([0-9]{2})\-([0-9]{2})/s",
                              "/(\([0-9\+\-]+\)) ?([0-9]{2})\-([0-9]{2})\-([0-9]{2})/s",
                              "/(\([0-9\+\-]+\)) ?([0-9]{3})\-([0-9]{2})/s",
                              "/(\([0-9\+\-]+\)) ?([0-9]{2})\-([0-9]{3})/s",
                              "/([0-9]{3})\-([0-9]{2})\-([0-9]{2})/s",
                              "/([0-9]{2})\-([0-9]{2})\-([0-9]{2})/s",
                              "/([0-9]{1})\-([0-9]{2})\-([0-9]{2})/s",
                              "/([0-9]{2})\-([0-9]{3})/s",
                              "/([0-9]+)\-([0-9]+)/s",
                              ),
                        array(
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2&ndash;\\3&nbsp;\\4:\\5:\\6\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2&ndash;\\3\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&nbsp;\\2&ndash;\\3&ndash;\\4\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&nbsp;\\2&ndash;\\3&ndash;\\4\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&nbsp;\\2&ndash;\\3\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&nbsp;\\2&ndash;\\3\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2&ndash;\\3\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2&ndash;\\3\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2&ndash;\\3\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F\\1&ndash;\\2\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F",
                              )
	);

	$RusAll= "абвгдеёжзийклмнопрстуфхцчшщъыьэюя";
	$RusV= "аеёиоуыэюя";
	$RusN= "бвгджзклмнпрстфхцчшщ";
	$RusX= "ьъй";

// начали
// для совместимости с WackoFormatter'ом
	if ($this->useWackoWikiCompatible) {
		$out = preg_replace("/\"\"(.*?)\"\"/si", "\xF1\xF1\xF1\xF1$1\xF1\xF1\xF1\xF1", $str);
	}

// "мягкие" переносы для русского текста
	if ($this->useSoftHyphen) {
		$out = preg_replace("/([".$RusAll."][".$RusX."])([".$RusAll."]{2})/sui", "$1SHYSHYSHYSHY$2", $out);
		$out = preg_replace("/([".$RusAll."][".$RusV."])([".$RusV."][".$RusAll."])/sui", "$1SHYSHYSHYSHY$2", $out);
		$out = preg_replace("/([".$RusV."][".$RusN."])([".$RusN."][".$RusV."])/sui", "$1SHYSHYSHYSHY$2", $out);
		$out = preg_replace("/([".$RusN."][".$RusV."])([".$RusN."][".$RusV."])/sui", "$1SHYSHYSHYSHY$2", $out);
		$out = preg_replace("/([".$RusV."][".$RusN."])([".$RusN."][".$RusN."][".$RusV."])/sui", "$1SHYSHYSHYSHY$2", 	$out);
		$out = preg_replace("/([".$RusV."][".$RusN."][".$RusN."])([".$RusN."][".$RusN."][".$RusV."])/sui", "$1SHYSHYSHYSHY$2", $out);	
	}

// амперсанд
	$out = preg_replace("/([\wёа-я]+)\s+\&\s+/sui", "$1&nbsp%^%^%&amp%^%^% ", $out);
// тире, дефисы, апострофы
	$out = preg_replace("/(^|>|\s)([\wёа-я]+([\-\'\/][\wёа-я]+)+)/sui", "$1\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F$2\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F", $out);
	$out = preg_replace("/(^|>|\s)\-\s+/si", "$1&#151%^%^%&nbsp;", $out);
	$out = preg_replace("/([\wёа-я]+)\s+\-\s+/si", "$1&nbsp%^%^%&#151%^%^% ", $out);
// знаки препинания
	$out = preg_replace("/(\s*)([,\?\!\.]*)/si", "$2$1", $out);
	$out = preg_replace("/(.*?)([\,\;])([^\-]+?)(.*?)/si", "$1$2 $3$4", $out);
	$out = preg_replace("/([^\(ЁА-ЯA-Z][\.\?\!])([ЁА-ЯA-Z])/s", "$1 $2", $out);
	$out = preg_replace("/(\s*)([\.\?\!]*)(\s*[ЁА-ЯA-Z])/s", "$2$1$3", $out);
	$out = preg_replace("/([\wёа-я]+)\.{3,}/si", "\xF0\xF0\xF0\xF0nobr\x0F\x0F\x0F\x0F$1&#133;\xF0\xF0\xF0\xF0/nobr\x0F\x0F\x0F\x0F", $out); // было sui
	$out = preg_replace("/\.{3,}/si", "&#133;", $out);
// кавычки
	$out = preg_replace("/(^|\s|>|\)|\()\"(.*?)\"/si", "$1&laquo;$2&raquo;", $out);
	$out = preg_replace("/(^|\s|>|\)|\()“(.*?)”/si", "$1&laquo;$2&raquo;", $out);
	$out = preg_replace("/(^|\s|>|\)|\()„(.*?)”/si", "$1&laquo;$2&raquo;", $out);
	$out = preg_replace("/„/si", "&#132;", $out);  // было sui
	$out = preg_replace("/“/si", "&#147;", $out); // было sui
	$out = preg_replace("/”/si", "&#148;", $out); // было sui
// спецсимволы
	$out = preg_replace("/\(c\)/i", "&#169;", $out);
	$out = preg_replace("/\(r\)/i", "&#174;", $out);
	$out = preg_replace("/\(tm\)/i", "&#153;", $out);
// номер
	$out = preg_replace("/(^|\s)no\.?\s+?(\d+)/si", "$1&#8470;$2", $out);
// телефонные номера
	if ($this->usePhoneCorrection) {
	    foreach ($phonemasks[0] as $index => $value) {
		$out = preg_replace($value, $phonemasks[1][$index], $out);
	    }
	}
// косметика
	$out = preg_replace("/(\&lt;)\s+?/si", "$1", $out);
	$out = preg_replace("/(\&gt;)\s+?/si", "$1", $out);
	$out = preg_replace("/(\"|\&quot;)\s+(\"|\&quot;)/si", "", $out);
	$out = str_replace("%^%^%", ";",
	       str_replace("\xF0\xF0\xF0\xF0", "<",
	       str_replace("\x0F\x0F\x0F\x0F", ">",
	       str_replace("\xF1\xF1\xF1\xF1", "\"\"",
	       str_replace("SHYSHYSHYSHY", "&shy;", $out)))));
// закончили
// для совместимости с WackoFormatter'ом все вернули назад
	return $out;
//
    }
}

?>