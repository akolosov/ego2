<?php

class cBeforeShowGRAvatarPlugin extends cCorePlugin {

	function __init(&$a_data = NULL) {
		return true;
	}

	function __exec(&$a_data = NULL) {
		$config		= $this->_owner->_owner->getConfiguration();
		$session	= $this->_owner->_owner->getSession();

		if (($config->use_gravatar) && ($config->use_gravatar_in_posts)) {
			$gravatar_url = $config->gravatar_url."/avatar.php?gravatar_id=".md5(trim($a_data['author_email']))."&default=".urlencode($config->gravatar_default)."&size=".$config->gravatar_size;
			$a_data['text'] = "<img class=\"gravatar\" src=\"".$gravatar_url."\" alt=\"\" />".$a_data['text'];
			
			return true;
		}	
	}
}

?>