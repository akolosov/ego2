<?php

class cErrorsHandler extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
		ini_set('display_errors', 1);
		error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
		set_error_handler("errorsHandler");
		set_exception_handler("exceptionsHandler");
	}

	function errorsHandler($errno, $errmsg, $file, $line) {
		$config  = $this->_owner->getConfiguration();
		
		if ($config->log_errors) {
			$this->logMessage("ERROR #".$errno." in file ".$file." in line ".$line.", message: ".$errmsg);
		}
	}
	
	function exceptionsHandler($e) {
		$config  = $this->_owner->getConfiguration();
		
		if ($config->log_exceptions) {
	  		$this->logMessage("EXCEPT: in file ".$e->getFile()." in line ".$e->getLine().", message: ".$e->getMessage());
		}
	}

	function logMessage($a_str) {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		if (is_null($config->log_file_name)) {
                        $config->log_file_name = cCoreConfig::LOGS_DIR."/".strftime("%d.%m.%Y", time());
                }

		if ($config->use_log) {
			$logfile = $config->log_file_name.(preg_match("/^(error|except).*/i", $a_str)?".err":".log");

			$fp = fopen($logfile,  "a+");
			flock($fp, LOCK_SH);
			fwrite($fp, strftime("%H:%M:%S", time())." - ".cEngineConfig::VERSION_NUM."/".cEngineConfig::VERSION_NAME." - ".$a_str." (ip: ".getenv("REMOTE_ADDR").", via: ".getenv("HTTP_X_FORWARDED_FOR").")\n");
			if (($this->_debug) && (preg_match("/^(error|except).*/i", $a_str)) && ($config->log_debug_mode)) {
				fwrite($fp, "-----------[ trace info begin ]------------\n".$this->getTrace()."\n------------[ trace info end ]-------------\n\n");
			}
			fclose($fp);
		}
	}

	function getTrace($a_level = 3) {
		$vDebug = debug_backtrace();
		$vFiles = array();
		for ($i = 0; $i < count($vDebug); $i++) {
			if ($i < $a_level) {
				continue;
			}
			$aFile = $vDebug[$i];
	
			$aFile['file']		= empty($aFile['file'])?"UNKNOWN":$aFile['file'];
			$aFile['line']		= empty($aFile['line'])?"UNKNOWN":$aFile['line'];
			$aFile['class']		= empty($aFile['class'])?"ROOT":$aFile['class'];
			$aFile['function']	= empty($aFile['function'])?"UNKNOWN":$aFile['function'];
			$aFile['type']		= empty($aFile['type'])?"void":$aFile['type'];
	
			$vFiles[] = "file: ".basename($aFile['file'])."; line: ".$aFile['line']."; function: ".$aFile['class']."->".$aFile['function']."()";
		}
		return implode("\n", $vFiles);
	}
}

?>
