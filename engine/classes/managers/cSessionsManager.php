<?php

class cSessionsManager extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

	function getSession() {
		return $this;
	}

	function initThis() {
		$this->translateHRURL($this->utils->makeHRURL($_SERVER["REQUEST_URI"]));
		$this->initSession();
	}
	
	protected function initSession() {
	}

	function translateHRURL($str) {
		
		$config  = $this->_owner->getConfiguration();
		
		if (strpos_x($str, "=") === false) {
			$elements = split("\/", $str); $i = 0;
			while ($i < sizeof($elements)) {
				$i++;
			}
		} else {
			$this->module = $_GET['module'];
		}
	}

}

?>
