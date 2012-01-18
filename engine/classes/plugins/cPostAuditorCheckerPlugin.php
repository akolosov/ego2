<?php

class cPostAuditorCheckerPlugin extends cCorePlugin {

	function __init(&$a_data = NULL) {
		return true;
	}

	function __exec(&$a_data = NULL) {
		$config		= $this->_owner->_owner->getConfiguration();
		$session	= $this->_owner->_owner->getSession();
		$i18n		= $this->_owner->_owner->getI18N();

		if (in_array($session->module, $config->PAM_in_modules)) {
			if (($session->data["secretkey_md5"] <> md5($session->data["secretkey"])) || (empty($session->data["secretkey"]))) {
				$session->post_err .= $i18n->errors['nocode'];
				return false;
			} else {
				return true;
			}
		}
	}
}

?>