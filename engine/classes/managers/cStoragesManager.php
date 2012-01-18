<?php
//
// cStoragesManager v0.2.2.1a
//
// Класс управления хранилищами данных
//
// (C)opyLeft & (C)odeRight Alexey Kolosov aka huNTer <alexey.kolosov@mail.ru>
//
// "cStoragesManager" released without warranty under the terms of the Artistic License.
// http://www.opensource.org/licenses/artistic-license.php
//
// $Id: cStoragesManager.php,v 1.1 2005/05/11 07:37:03 hunter Exp $
//


class cStorage extends cCoreClass {

	private $_source	= NULL;
	private $_name		= NULL;

	function __construct($a_owner, $a_name, $a_sourceType = array()) {

		parent::__construct($a_owner, $a_owner->_debug);

		$this->_name	= $a_name;
	
		if ($a_sourceType['type'] == "text") {
			if (!empty($a_sourceType['source'])) {
				$this->_source = &new cStorage_TextFile($this, $a_sourceType['source'], $a_sourceType['delimiter']);
			} else {
				write2log("ERROR: cannot init data storage");
			}
		}
	}

	function setDelimiter($a_delimiter) {
		if (isset($this->_source)) {
			return $this->_source->setDelimiter($a_delimiter);
		}
	}

	function Append($data = array(), $lazzy = false) {
		if (isset($this->_source)) {
			return $this->_source->Append($data, $lazzy);
		}
	}

	function Update($id, $data = array(), $lazzy = false, $byindex = true) {
		if (isset($this->_source)) {
			return $this->_source->Update($id, $data, $lazzy, $byindex);
		}
	}

	function setBuffer($buffer = array(), $save = false) {
		if (isset($this->_source)) {
			return $this->_source->setBuffer($buffer, $save);
		}
	}

	function getBuffer() {
		if (isset($this->_source)) {
			return $this->_source->getBuffer();
		}
	}

	function setSource($a_source, $load = true) {
		if (isset($this->_source)) {
			return $this->_source->setSource($a_source, $load);
		}
	}
	
	function getLastID() {
		if (isset($this->_source)) {
			return $this->_source->getLastID();
		}
	}

	function getIDbyData($data) {
		if (isset($this->_source)) {
			return $this->_source->getIDbyData($data);
		}
	}

	function getData($id, $byindex = true) {
		if (isset($this->_source)) {
			return $this->_source->getData($id, $byindex);
		}
	}
	
	function Sort($UserProc = "") {
		if (isset($this->_source)) {
			return $this->_source->Sort($UserProc);
		}
	}

	function Save() {
		if (isset($this->_source)) {
			return $this->_source->Save();
		}
	}
	
	function Load() {
		if (isset($this->_source)) {
			return $this->_source->Load();
		}
	}
	
	function Reverse() {
		if (isset($this->_source)) {
			return $this->_source->Reverse();
		}
	}

	function Unique() {
		if (isset($this->_source)) {
			return $this->_source->Unique();
		}
	}

	function Zap() {
		if (isset($this->_source)) {
			return $this->_source->Zap();
		}
	}

}

class cStorage_TextFile extends cStorage {

	function __construct($a_owner, $a_source = "", $a_delimiter = "@@") {

		$this->_properties["buffer"]	= array();
		$this->_properties["locked"]	= false;
		$this->_properties["fp"] 	= -1;
		$this->_properties["lazzy"]	= false;
		$this->_properties["reversed"]	= false;
		$this->_properties["sorted"]	= false;
		$this->_properties["sortproc"]	= NULL;
		$this->_properties["loaded"]	= false;
		$this->_properties["changed"]	= false;

		parent::__construct($a_owner, NULL, NULL);

		$this->_properties["source"]	= $a_source;
		$this->_properties["delimiter"]	= $a_delimiter;

		$this->Load();

	}
	
	function __destruct() {
		$this->Save();
		if ($this->_properties["fp"] <> -1)  {
			fclose($this->_properties["fp"]);
		}
	}

	function Zap() {
		$this->_properties["buffer"]	= array();
		$this->_properties["lazzy"]	= false;
		$this->_properties["loaded"]	= false;
		$this->_properties["sorted"]	= false;
		$this->_properties["sortproc"]	= NULL;
		$this->_properties["changed"]	= true;
		return true;
	}

	function Load() {
		if (file_exists($this->_properties["source"])) {
			$this->_properties["buffer"] = explode("\n", trim(chop(file_get_contents($this->_properties["source"]))));
			
			if ($this->_debug) {
				write2log("data from \"".$this->_properties["source"]."\" loaded");
			}
			
			$this->_properties["loaded"]	= true;
			$this->_properties["changed"]	= false;
			$this->_properties["sorted"]	= false;
			$this->_properties["sortproc"]	= NULL;
		} else {
			$this->Zap();
		}

		return count($this->_properties["buffer"]);
	}
	
	function setDelimiter($a_delimiter) {
		$this->_properties["delimiter"] = $a_delimiter;
	}
	
	function Save() {

		$_res = false; 

		if ((!is_null($this->_properties["buffer"])) && (!empty($this->_properties["buffer"]))) {
			if ($this->_properties["changed"]) {
				if ($this->_properties["fp"] = -1) {
					$this->_properties["fp"] = fopen($this->_properties["source"], "w+");
					
					if ($this->_debug) {
						write2log("open for write \"".$this->_properties["source"]."\"");
					}
				}

				if ($this->_properties["reversed"]) {
					$this->Reverse();
				}
				
				if (($this->_properties["sorted"]) && (!strpos($this->_properties["sortproc"], "Keys"))) {
					$this->Sort("CompareByID");
				}

				if ($this->_properties["fp"])  {
						$this->Lock();
						$_res = fwrite($this->_properties["fp"], trim(chop(implode("\n", $this->_properties["buffer"]))));
						$this->UnLock();
						
						if ($this->_debug) {
							if ($_res) {
								write2log("write data to \"".$this->_properties["source"]."\"");
							} else {
								write2log("ERROR: cannot write data to \"".$this->_properties["source"]."\"");
							}
						}
						$this->_properties["changed"] = false;
				} else {
					if ($this->_debug) {
						write2log("ERROR: cannot save storage - ".$this->_properties["source"]);
					}
				}
			} else {
				if ($this->_debug) {
					write2log($this->_properties["source"]."don't save - no changes maded");
				}
			}
		}

		return $_res;
		
	}

	function Lock() {
		if ($this->_properties["fp"]) {
			$this->_properties["locked"] = flock($this->_properties["fp"], LOCK_EX);
		}
		return $this->_properties["locked"];
	}
	
	function UnLock() {
		if (($this->_properties["fp"]) && ($this->_properties["locked"])) {
			$this->_properties["locked"] = (flock($this->_properties["fp"], LOCK_UN))?false:true;
		}
		return !$this->_properties["locked"];
	}

	function Append($data = array(), $lazzy = false) {
		if (!empty($data)) {
			if (is_array($data)) {
				$this->_properties["buffer"][]	= implode($this->_properties["delimiter"], $data);
			} else {
				$this->_properties["buffer"][]	= $data;
			}
			$this->_properties["loaded"]	= true;
			$this->_properties["changed"]	= true;
			if (!$lazzy) {
				$this->_properties["lazzy"] = false;
				$this->Save();
			} else {
				$this->_properties["lazzy"] = true;
			}
		}
		return count($this->_properties["buffer"]);
	}

	function Update($id, $data = array(), $lazzy = false, $byindex = true) {

		$_res = false; 

		if (!empty($data)) {
			if (!$byindex) {
				$found = $this->getIDbyData("^".$id.$this->_properties["delimiter"]);
				$id = ($found)?$found:$id;
			} elseif (($id-1) > $this->getLastID()) {
				return $_res;
			}
			if (is_array($data)) {
				$this->_properties["buffer"][$id-1]	= implode($this->_properties["delimiter"], $data);
			} else {
				$this->_properties["buffer"][$id-1]	= $data;
			}
			
			$this->_properties["loaded"]		= true;
			$this->_properties["changed"]		= true;
			if ($lazzy) {
				$this->_properties["lazzy"]	= true;
			} else {
				$this->_properties["lazzy"]	= false;
				$this->Save();
			}
		}
		return count($this->_properties["buffer"]);
	}

	function setBuffer($buffer = array(), $save) {
		if (is_array($buffer)) {
			$this->_properties["buffer"]	= $buffer;
			$this->_properties["loaded"]	= true;
			$this->_properties["changed"]	= true;
			$this->_properties["sorted"]	= false;
			$this->_properties["sortproc"]	= NULL;
			$this->_properties["reversed"]	= false;
			if ($save) {
				$this->Save();
			}
		}
	}

	function getBuffer() {
		if ($this->_properties["loaded"]) {
			if ($this->_properties["buffer"]) {
				return $this->_properties["buffer"];
			}
		} else {
			return NULL;
		}
	}
	function setSource($a_source, $load = true) {
		if ((!empty($a_source)) && (trim($this->_properties["source"]) <> trim($a_source))) {

			if ($this->_properties["fp"]) {
				if ($this->_properties["lazzy"]) {
					$this->_properties["lazzy"] = false;
					$this->Save();
				}
				if ($this->_properties["fp"] <> -1) {
					fclose($this->_properties["fp"]);
				}
				
				if ($this->_debug) {
					write2log("close data source \"".$this->_properties["source"]."\"");
				}
				
				$this->_properties["fp"] = -1;
			}

			$this->_properties["source"]	= $a_source;
			$this->_properties["reversed"]	= false;
			$this->_properties["sorted"]	= false;
			$this->_properties["sortproc"]	= NULL;
			$this->_properties["lazzy"]	= false;
			
			if ($load) {
				$this->Load();
			} else {
				$this->Zap();
				$this->_properties["changed"] = false;
			}

			return true;
		} else {
			return false;
		}
	}

	function getLastID() {
		if ($this->_properties["loaded"]) {
			return count($this->_properties["buffer"]);
		} else {
			return 0;
		}
	}

	function getIDbyData($data) {
		if ($this->_properties["loaded"]) {
			$_res = 0;
			foreach($this->_properties["buffer"] as $str) {
				if (preg_match("/".$data."/sui", $str)) {
					return ($_res+1);
				}
				$_res++;
			}
		}
		return false;
	}

	function getData($id, $byindex = true) {
		if ($this->_properties["loaded"]) {
			if ($byindex) {
				return explode($this->_properties["delimiter"], $this->_properties["buffer"][$id-1]);
			} else {
				$found = $this->getIDbyData("^".$id.$this->_properties["delimiter"]);
				if ($found) {
					return explode($this->_properties["delimiter"], $this->_properties["buffer"][$found-1]);
				}
			}
		} else {
			return NULL;
		}
	}
	
	function Sort($UserProc = "") {
		if ($this->_properties["loaded"]) {
			if (empty($UserProc)) {
				sort($this->_properties["buffer"], SORT_LOCALE_STRING);
			} else {
				usort($this->_properties["buffer"], $UserProc);
			}
			$this->_properties["sorted"]	= (empty($UserProc))?false:true;
			$this->_properties["sortproc"]	= $UserProc;
			$this->_properties["reversed"]	= false;
			return true;
		} else {
			return false;
		}
	}

	function Reverse() {
		if ($this->_properties["loaded"]) {
			$this->_properties["buffer"]	= array_reverse($this->_properties["buffer"]);
			$this->_properties["sorted"]	= false;
			$this->_properties["sortproc"]	= NULL;
			$this->_properties["reversed"]	= ($this->_properties["reversed"])?false:true;
			return true;
		} else {
			return false;
		}
	}

	function Unique() {
		if ($this->_properties["loaded"]) {
			$this->_properties["buffer"]	= array_unique($this->_properties["buffer"]);
			$this->_properties["changed"]	= true;
			$this->_properties["sorted"]	= false;
			$this->_properties["sortproc"]	= NULL;
			$this->_properties["reversed"]	= false;
			return true;
		} else {
			return false;
		}
	}

}

class cStoragesManager extends cCoreClass {

	function __construct($a_owner, $a_sourceType = array()) {

		$this->_properties["storages"]	= array();
		$this->_properties["current"]	= NULL;

		parent::__construct($a_owner, $a_owner->_debug);

		$this->_properties["defaults"]	= $a_sourceType;

		if (!empty($this->_properties["defaults"]['source'])) {
			$this->setSource($this->_properties["defaults"]['source']);
		}
	}

	function setSource($a_source, $load = true) {
		if (!isset($this->_properties["storages"][trim($a_source)])) {
			$this->_properties["defaults"]["source"] = trim($a_source);
			
			if ($this->_debug) {
				write2log("try to create storage to \"".$a_source."\"");
			}
			
			$this->_properties["storages"][trim($a_source)] = &new cStorage($this, $a_source, $this->_properties["defaults"]);
			$this->_properties["current"] = &$this->_properties["storages"][trim($a_source)];
			
			if ($this->_debug) {
				write2log("storage to \"".$a_source."\" created");
			}
		} else {
			$this->_properties["current"] = &$this->_properties["storages"][trim($a_source)];

			if ($this->_debug) {
				write2log("storage changed to \"".$a_source."\"");
			}
			$this->_properties["current"]->setSource($a_source, false);
		}
	}

	function Append($data = array(), $lazzy = false) {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Append($data, $lazzy);
		}
	}

	function Update($id, $data = array(), $lazzy = false, $byindex = true) {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Update($id, $data, $lazzy, $byindex);
		}
	}

	function setBuffer($buffer = array(), $save = false) {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->setBuffer($buffer, $save);
		}
	}

	function getBuffer() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->getBuffer();
		}
	}

	function getSource ($a_source) {
		if (!isset($this->_properties["storages"][$a_source])) {
			$this->setSource($a_source);
		}
		return $this->_properties["storages"][$a_source];
	}
	
	function getLastID() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->getLastID();
		}
	}

	function getIDbyData($data) {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->getIDbyData($data);
		}
	}

	function getData($id, $byindex = true) {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->getData($id, $byindex);
		}
	}
	
	function Sort($UserProc = "") {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Sort($UserProc);
		}
	}

	function Save() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Save();
		}
	}
	
	function Load() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Load();
		}
	}
	
	function Reverse() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Reverse();
		}
	}

	function Unique() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Unique();
		}
	}

	function Zap() {
		if (isset($this->_properties["current"])) {
			return $this->_properties["current"]->Zap();
		}
	}

}

?>