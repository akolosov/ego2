<?php

class cEngineConfig {
	const NAME		= "eGo/2";
	const VERSION_NUM	= "0.5.0.2";
	const VERSION_NAME	= "Mephisto";
	const AUTHOR		= "Alexey Kolosov";
	const EMAIL		= "alexey.kolosov@mail.ru";
	const ICQ		= "5005747";
	const SITE		= "http://ego.dev.b0b.org/";
}

class cSiteConfig {
	const OWNER_NAME	= "huNTer";
	const OWNER_EMAIL	= "hunter@ego.b0b.org";
}

class cSecurityLevels {
	const DELIMITER	= "-";
	const READ	= "r";
	const WRITE	= "w";
	const COMMENT	= "c";
	const CHANGE	= "e";
	const DELETE	= "x";
	const BOOKMARK	= "b";
	const KEYWORD	= "k";
}

class cFormatTokens {
	const CUT	= "/[\s\n>](\[cut\])|(\[cut\s+(.*?)\])|(\[cut=(.*?)\])[\s|\n]?/sui";
	const CUT_TOKEN	= "[cut";
	const REM	= "/[\s\n>]\[rem(?i:\s+)?(?i:\s+pos=(.*?))?(?i:\s+w=(.*?))?(?i:\s+h=(.*?))?\](.*?)\[\/rem\][\s|\n]?/sui";
	const HIDE	= "/[\s\n>]\[hide(?i:[=|\s]+)?(.*?)(?i:\s+pos=(.*?))?(?i:\s+w=(.*?))?(?i:\s+h=(.*?))?\](.*?)\[\/hide\][\s|\n]?/sui";
	const HREF	= "/\<a(?i:.*?)href=\"(.*?)\"(?i:.*?)\>(.*?)\<\/a\>/ui";
}

class cFormatLevels {
	const SHOW	= 1;
	const COMMENT	= 2;
	const QUOTE	= 3;
	const EXPORT	= 4;
	const EMAIL	= 5;
	const EDIT	= 6;
	const GIZMO	= 7;
}

class cHooks {
	const beforeSavePost		= 1;
	const afterSavePost		= 2;
	const beforeShowPost		= 3;
	const afterShowPost		= 4;
	const beforeExportPost		= 5;
	const afterExportPost		= 6;
	const beforeDeletePost		= 7;
	const afterDeletePost		= 8;
	const beforeFormatPost		= 9;
	const afterFormatPost		= 10;
	const beforeFilterContent	= 11;
	const afterFilterContent	= 12;
	const beforeExportThisPost	= 13;
	const afterExportThisPost	= 14;
	const beforeShowPostForm	= 15;
	const afterShowPostForm		= 16;
	const beforePostFormProcess	= 17;
	const afterPostFormProcess	= 18;
// cStorageManager	
	const beforeSaveStorage		= 19;
	const afterSaveStorage		= 20;
	const beforeZapStorage		= 21;
	const afterZapStorage		= 22;
	const beforeAppendStorage	= 23;
	const afterAppendStorage	= 24;
	const beforeUpdateStorage	= 25;
	const afterUpdateStorage	= 26;
	const beforeSetNewSourceStorage	= 27;
	const afterSetNewSourceStorage	= 28;
	const beforeSetSourceStorage	= 29;
	const afterSetSourceStorage	= 30;
	const beforeCreateStorage	= 31;
	const afterCreateStorage	= 32;
	const beforeLoadStorage		= 33;
	const afterLoadStorage		= 34;
//
}

class cCoreClass {
	public		$_owner;
	public		$_debug;
	public		$_properties = array();

	function __construct($a_owner = NULL, $a_debug = false) {
		$this->_owner = $a_owner;
		$this->_debug = $a_debug;
	}

	function __set($name, $value) {
		if ($this->_debug) {
			write2log(get_class($this)." setting ".$name);
		}
		$this->_properties[strtolower($name)] = $value;
	}

	function __get($name) {
		if ($this->_debug) {
			write2log(get_class($this)." getting ".$name);
		}
		return $this->_properties[strtolower($name)];
	}
	
	function initThis() {
	}

}

class cUser extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

}

class cCorePlugin extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

	function __init(&$a_data = NULL) {
		return true;
	}

	function __exec(&$a_data = NULL) {
	}

}

?>
