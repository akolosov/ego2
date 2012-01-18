<?php

class cSecurityManager extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

	function canUser($a_module, $a_right) {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$modulerights = split($config->rights_module_delimiter, $session->user['rights']);

		foreach ($modulerights as $moduleright) {

			if (is_null($moduleright)) {
				continue;
			}

			$mright = split("=", $moduleright);

			if (trim($mright[0]) == trim($a_module)) {
				if (!(strpos_x($mright[1], $a_right) === false)) {
					return true;
				}
			}
		}

		return false;
	}

	function inBlackList($a_ip) {
		
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		if ($config->use_blacklist) {
			foreach ($session->blacklist as $black_ip) {
				if (!empty($black_ip)) {
					$res = preg_match('/^'.trim($black_ip).'$/', $a_ip);
					if ($res) {
						return true;
					}
				}
			}
		}

		return false;
	}

	function checkPassword() {

		$session = $this->_owner->getSession();
	
		if (trim($session->user['enteredpasswd']) == trim($session->user['passwd'])) {
			return true;
		} else {
			return false;
		}
	}
	
	function readUserInfo() {
	
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		$session->storage->setSource($config->users_data_path);
		$found = $session->storage->getIDbyData("^".trim($session->user['name']).$config->data_delimiter);

		if ($found > 0) {
			$user = $session->storage->getData($found);

			$session->user['passwd'] = $user[1];

			if (!is_null($user[2])) {
			    $session->user['mail'] = $user[2];
			}
			
			if (!is_null($user[3])) {
				$session->user['rights'] = $user[3];
			} else {
				$session->user['rights'] = $config->default_user_rights;
			}
			
			$user[4] = trim($user[4]);
			if ((!is_null($user[4])) && ($user[4] == "Y")) {
				$session->user['isadmin'] = true;
			} else {
				$session->user['isadmin'] = false;
			}
			
			return true;
		}
		
		return false;
	}
	
	function isValidUsername($a_username) {
		if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $a_username)) {
			return false;
		} else {
			return true;
		}
	}

	function addUserInfo() {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		if (is_null($session->user['name']) || is_null($session->user['mail']) || is_null($session->user['passwd'])) {
			return;
		}
		
		$session->storage->setSource($config->users_data_path);
		$str = trim($session->user['name']).$config->data_delimiter.$session->user['passwd'].$config->data_delimiter.trim($session->user['mail']).$config->data_delimiter.$session->user['rights'].$config->data_delimiter.($session->user['isadmin']?"admin":"");
		$session->storage->Append(explode($config->data_delimiter, $str));
		
	}

	function updateUserInfo() {
	
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$session->storage->setSource($config->users_data_path);
		$found = $session->storage->getIDbyData("^".trim($session->user['name']).$config->data_delimiter);

		if ($found > 0) {
			$str = trim($session->user['name']).$config->data_delimiter.$session->user['passwd'].$config->data_delimiter.trim($session->user['mail']).$config->data_delimiter.$session->user['rights'].$config->data_delimiter.($session->user['isadmin']?"admin":"");
			$session->storage->Update($found, explode($config->data_delimiter, $str));
		} else {
			$this->addUserInfo();
		}
	}

}

?>
