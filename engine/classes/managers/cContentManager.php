<?php

class cContentManager extends cCoreClass {
	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}
	
	function initThis() {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		if ((in_array($session->module, array_keys($config->addons_by_modules))) && (!in_array($session->sub, $config->no_addons_in_subactions)) && (!in_array($session->action, $config->no_addons_in_actions))) {
			$this->_addons = new $config->modules_to_classes["addons"]($this);
		}
		$this->_module = new $config->modules_to_classes[$session->module]($this);


	}

	function showContent() {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		if (file_exists($config->templates_path."/".$session->style."/a_style.php")) {
			include_once($config->templates_path."/".$session->style."/a_style.php");
		}

	}
	
	function getConfiguration() {
		return $this->_owner->getConfiguration();
	}

	function getSession() {
		return $this->_owner->getSession();
	}

	function getI18N() {
		return $this->_owner->getI18N();
	}

}

?>