<?php
class cMyselfStoragesManager extends cStoragesManager {

	function setSource($a_source, $load = true) {
		if (!isset($this->_properties["storages"][trim($a_source)])) {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeSetNewSourceStorage, &$this->_properties["storages"]);
			parent::setSource($a_source, $load);
			$this->_owner->_pluginsManager->execHook(cHooks::afterSetNewSourceStorage, &$this->_properties["storages"][trim($a_source)]);
		} else {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeSetSourceStorage, &$this->_properties["storages"][trim($a_source)]);
			parent::setSource($a_source, $load);
			$this->_owner->_pluginsManager->execHook(cHooks::afterSetSourceStorage, &$this->_properties["storages"][trim($a_source)]);
		}
	}

	function Append($data = array(), $lazzy = false) {
		if (isset($this->_properties["current"])) {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeAppendStorage, &$data);
			$result = parent::Append($data, $lazzy);
			$this->_owner->_pluginsManager->execHook(cHooks::afterAppendStorage, &$data);

			return $result;
		}
	}

	function Update($id, $data = array(), $lazzy = false, $byindex = true) {
		if (isset($this->_properties["current"])) {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeUpdateStorage, &$data);
			$result = parent::Update($id, $data, $lazzy, $byindex);
			$this->_owner->_pluginsManager->execHook(cHooks::afterUpdateStorage, &$data);

			return $result;
		}
	}

	function Save() {
		if (isset($this->_properties["current"])) {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeSaveStorage, &$this->_properties["current"]);
			$result = parent::Save();
			$this->_owner->_pluginsManager->execHook(cHooks::afterSaveStorage, &$this->_properties["current"]);

			return $result;
		}
	}
	
	function Load() {
		if (isset($this->_properties["current"])) {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeLoadStorage, &$this->_properties["current"]);
			$result = parent::Load();
			$this->_owner->_pluginsManager->execHook(cHooks::afterLoadStorage, &$this->_properties["current"]);
			
			return $result;
		}
	}
	
	function Zap() {
		if (isset($this->_properties["current"])) {
			$this->_owner->_pluginsManager->execHook(cHooks::beforeZapStorage, &$this->_properties["current"]);
			$result = parent::Zap();
			$this->_owner->_pluginsManager->execHook(cHooks::afterZapStorage, &$this->_properties["current"]);

			return $result;
		}
	}

}

?>