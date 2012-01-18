<?php

class cPostAuditorMakerPlugin extends cCorePlugin {

	function __init(&$a_data = NULL) {
		$config  = $this->_owner->_owner->getConfiguration();
		$session = $this->_owner->_owner->getSession();
		
		srand((double)microtime()*1000000);;
		for ($i = 0; $i < $config->PAM_digits_count; $i++) {
			$nums[$i] = rand(0, 9);
		}
		$session->secret_key = implode("", $nums);
		$session->secret_key_array = $nums; 
		return true;
	}

	function __exec(&$a_data = NULL) {
		$config  = $this->_owner->_owner->getConfiguration();
		$session = $this->_owner->_owner->getSession();
		$i18n	 = $this->_owner->_owner->getI18N();

		if (in_array($session->module, $config->PAM_in_modules)) {
			$this->makeDigits();
			if (file_exists($config->styles_modules_path."/".$session->style."/".$session->module."/add/auditor.php")) {
        		      require($config->styles_modules_path."/".$session->style."/".$session->module."/add/auditor.php");
        		}
		}
		
		return true;
	}
	
	function makeDigits () {
		$config  = $this->_owner->_owner->getConfiguration();
		$session = $this->_owner->_owner->getSession();

		srand((double)microtime()*1000000);
		$image = imagecreate(120, 25);
		$white = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
		$gray  = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);
		$darkgray = imagecolorallocate($image, 0x30, 0x30, 0x30);
		for ($i = 0; $i < $config->PAM_lines_count; $i++) { 
			$x1 = rand(0, 120); $y1 = rand(0, 25); $x2 = rand(0, 120); $y2 = rand(0, 25); imageline($image, $x1, $y1, $x2, $y2, $gray);
		}
		for ($i = 0; $i < $config->PAM_digits_count; $i++) {
			$fnt = rand(3, 5); $x = $x + rand(12, 20); $y = rand(4, 9);
			imagestring($image, $fnt, $x, $y, $session->secret_key_array[$i], $darkgray);
		}
		imagepng($image, $config->cache_data_path."/secrets/".md5($session->secret_key).".png");
		imagedestroy($image);
		
	}
}

?>
