<?php

class cConfigsManager extends cCoreClass {

	function __construct($a_owner, $a_cfgFile = "config.php") {
		parent::__construct($a_owner, $a_owner->_debug);
		
		if (file_exists($a_cfgFile)) {
			include_once($a_cfgFile);
		}
	}
	
	function GetConfiguration() {
		return $this;
	}

}

?>
