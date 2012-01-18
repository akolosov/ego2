<?php

class cAboutContent extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}
	
	function showContent() {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		if (file_exists($config->styles_modules_path."/".$session->style."/a_about.php")) {
			require($config->styles_modules_path."/".$session->style."/a_about.php");
		}
	}

}

?>