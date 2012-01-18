<?php

class cPluginsManager extends cCoreClass {

	private $_hooks = NULL;

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
		$this->_hooks = NULL;
	}

	function initThis($a_hooks = array()) {
		if (!is_null($a_hooks)) {
			$this->_hooks = $a_hooks;
		}
	}

	function execHook($a_hook, &$a_data = NULL) {
		if (!is_null($this->_hooks)) {
			if (in_array($a_hook, array_keys($this->_hooks))) {
				$hook = $this->_hooks[$a_hook];
				if ((!empty($hook)) && (is_array($hook))) {
					foreach (array_keys($hook) as $class) {
						if (is_null($hook[$class])) {
							$hook[$class] = new $class($this);
						}
						if ($hook[$class]->__init(&$a_data)) {
							return $hook[$class]->__exec(&$a_data);
						}
					}
				}
			}
		}
		return true;
	}

}

?>