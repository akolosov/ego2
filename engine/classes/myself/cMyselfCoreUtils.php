<?php

class cMyselfCoreUtils extends cCoreUtils {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

	function makeHRURL($str) {
		$config = $this->_owner->getConfiguration();
		return (((strpos_x($str, "http://") === false) and (strpos_x($str, "index.php?") === false) and ($config->use_HRURL))?"index.php?":"").parent::makeHRURL($str);
	}

}

?>