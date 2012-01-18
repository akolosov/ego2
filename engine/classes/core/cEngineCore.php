<?php

class cEngineCore extends cCoreClass {
	
	public $_errorsHandler		= NULL;
	
	function __construct($a_owner, $a_debug) {
		parent::__construct($a_owner, $a_debug);
//
		$this->_errorsHandler	= new cErrorsHandler($this);
	}
}
?>
