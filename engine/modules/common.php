<?php

function getMicroTime(){
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
}

function getProcessTime($a_start_time){
  $t = (getMicroTime() - $a_start_time);
  return substr_x($t, 0, 5);
}

function write2log($str) {
	global $engine;
	if (isset($engine)) {
		$engine->_errorsHandler->logMessage($str);
	}
}

function errorsHandler($errno, $errmsg, $file, $line) {
	global $engine;
	if (isset($engine)) {
		$engine->_errorsHandler->errorsHandler($errno, $errmsg, $file, $line);
	}
}

function exceptionsHandler($e) {
	global $engine;
	if (isset($engine)) {
		$engine->_errorsHandler->exceptionsHandler($e);
	}
}

function substr_x ($string, $start, $length = 0) {
  if ($start < 0) {
    $length = $start*(-1);
    $start = strlen_x ($string)-$length;
  }
  return mb_substr ($string, $start, $length, "UTF-8");
}

function strlen_x ($string) {
  return mb_strlen ($string, "UTF-8");
}

function strpos_x ($string, $needle, $offset = 0) {
  return mb_strpos ($string, $needle, $offset, "UTF-8");
}

function __autoload($a_class) {

	if (preg_match("/Myself/u", $a_class)) {
		$filename = cCoreConfig::CLASSES_PATH."/myself/".$a_class.".php";
	} elseif (preg_match("/Manager/u", $a_class)) {
		$filename = cCoreConfig::CLASSES_PATH."/managers/".$a_class.".php";
	} elseif (preg_match("/Formatter/u", $a_class)) {
		if ($a_class == "WackoFormatterConfigDefault") {
			$filename = cCoreConfig::CLASSES_PATH."/formatters/WackoFormatter.php";
		} else {
			$filename = cCoreConfig::CLASSES_PATH."/formatters/".$a_class.".php";
		}
	} elseif (preg_match("/Core/u", $a_class)) {
		$filename = cCoreConfig::CLASSES_PATH."/core/".$a_class.".php";
	} elseif (preg_match("/Handler/u", $a_class)) {
		$filename = cCoreConfig::CLASSES_PATH."/handlers/".$a_class.".php";
	} elseif (preg_match("/Content/u", $a_class)) {
		$filename = cCoreConfig::CLASSES_PATH."/contents/".$a_class.".php";
	} elseif (preg_match("/Plugin/u", $a_class)) {
		$filename = cCoreConfig::CLASSES_PATH."/plugins/".$a_class.".php";
	} else {
		$filename = cCoreConfig::CLASSES_PATH."/".$a_class.".php";
	}

	require_once($filename);
}

function CompareKeys($akey, $bkey) {
	$a = split(cCoreConfig::DELIMITER, $akey); $aa = split("\|", $a[2]);
	$b = split(cCoreConfig::DELIMITER, $bkey); $bb = split("\|", $b[2]);
	
	if (count($aa) == count($bb)) {
		return 0;
	}
	return (count($aa) > count($bb)) ? -1 : +1; // orig +1 : -1; modified for reverse
}

function CompareComments($akey, $bkey) {
	$a = split(cCoreConfig::DELIMITER, $akey);
	$b = split(cCoreConfig::DELIMITER, $bkey);
	
	if ($a[1] == $b[1]) {
		return 0;
	}
	return ($a[1] > $b[1]) ? -1 : +1; // orig +1 : -1; modified for reverse
}

function CompareByUpdate($akey, $bkey) {
	$a = split(cCoreConfig::DELIMITER, $akey);
	$b = split(cCoreConfig::DELIMITER, $bkey);
	
	if ($a[3] == $b[3]) {
		return 0;
	}
	
	return ($a[3] > $b[3]) ? -1 : +1; // orig +1 : -1; modified for reverse
}

function CompareByID($akey, $bkey) {
	$a = split(cCoreConfig::DELIMITER, $akey);
	$b = split(cCoreConfig::DELIMITER, $bkey);
	
	if ($a[0] == $b[0]) {
		return 0;
	}
	
	return ($a[0] > $b[0]) ? +1 : -1; // orig +1 : -1; modified for reverse
}

function CompareGroups ($a, $b) {
	return strcmp($a["group"], $b["group"]);
}


?>