<?php

class cI18NClass extends cCoreClass {

	private $language = array();

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

	function __set($name, $value) {
		if ($this->_debug) {
			write2log(get_class($this)." setting ".$name);
		}
		$this->language[$name] = $value;
	}

	function __get($name) {
		if ($this->_debug) {
			write2log(get_class($this)." getting ".$name);
		}
		return $this->language[$name];
	}

	function GetI18N() {
		return $this;
	}

	function initThis($a_i18nFileName = "UTF-8.php") {
		include_once($a_i18nFileName);
	}

}

class cI18NManager extends cI18NClass {

	function __construct($a_owner) {
		parent::__construct($a_owner);
	}

}

?>
