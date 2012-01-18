<?php

class cMyselfSessionsManager extends cSessionsManager {

	// preinit some variables and error handler be quiet
	public	$blacklist	= array();
	public	$user		= array();
	public	$data		= array();
	public	$blog		= array();
	public	$gizmo		= array();
	public	$comment	= array();
	public	$postdays	= array();
	public	$days		= array();
	public	$ids		= NULL;
	public	$save		= NULL;
	public	$author		= NULL;
	public	$mounth		= NULL;
	public	$post_err	= NULL;
	//

	function initThis() {
	
		$config  = $this->_owner->getConfiguration();

		if ($config->default_method == $config->default_method) {
			$this->data	= $_POST;
		} else {
			$this->data	= $_GET;
		}

		if ($config->use_blacklist) {
			$this->storage->setSource($config->blacklist_data_path);
			$this->blacklist = $this->storage->getBuffer();
			if (($this->security->inBlackList(getenv("REMOTE_ADDR"))) || ($this->security->inBlackList(getenv("HTTP_X_FORWARDED_FOR")))) {
				header("Location: ".$config->blacklist_redirect_to);
			}
		}

		$this->translateHRURL(str_replace("index.php", "", $this->utils->makeHRURL($_SERVER["REQUEST_URI"])));
		
		$this->initSession();
		
		// check and fix cookies
		if (($_COOKIE["keys01"] == "none") || ($_COOKIE["keys02"] == "none")) {
			$_COOKIE["keys01"] = "none";
			$_COOKIE["keys02"] = "none";
		}
		if (($_COOKIE["comments01"] == "none") || ($_COOKIE["comments02"] == "none")) {
			$_COOKIE["comments01"] = "none";
			$_COOKIE["comments02"] = "none";
		}
		if (($_COOKIE["search01"] == "none") || ($_COOKIE["search02"] == "none")) {
			$_COOKIE["search01"] = "none";
			$_COOKIE["search02"] = "none";
		}
		if (($_COOKIE["links01"] == "none") || ($_COOKIE["links02"] == "none")) {
			$_COOKIE["links01"] = "none";
			$_COOKIE["links02"] = "none";
		}
	}
	
	protected function initSession() {
		
		$config  = $this->_owner->getConfiguration();
	
		if (is_null($this->theme)) {
			$this->theme  = $_GET["theme"];
		}
		if (is_null($this->theme)) {
			$this->theme  = $this->data["theme"];
		}
		if (is_null($this->theme)) {
			$this->theme  = $_COOKIE["theme"];
		}
		
		if (is_null($this->style)) {
			$this->style  = $_GET["style"];
		}
		if (is_null($this->style)) {
			$this->style  = $this->data["style"];
		}
		if (is_null($this->style)) {
			$this->style  = $_COOKIE["style"];
		}
		
		if (is_null($this->language)) {
			$this->language  = $_GET["language"];
		}
		if (is_null($this->language)) {
			$this->language  = $this->data["language"];
		}
		if (is_null($this->language)) {
			$this->language  = $_COOKIE["language"];
		}

		if (is_null($this->search)) {
			$this->search  = $_GET["search"];
		}
 		if (is_null($this->search)) {
			$this->search  = $this->data["search"];
		}

		if (!is_null($_GET["username"])) {
			$this->user["name"] = $_GET["username"];
		}
		if (is_null($this->user["name"])) {
			$this->user["name"] = $_COOKIE["username"];
		}
		if (is_null($this->user["name"])) {
			$this->user["name"] = $this->data["name"];
		}
		
		if (!is_null($_GET["usermail"])) {
			$this->user["mail"] = $_GET["usermail"];
		}
		if (is_null($this->user["mail"])) {
			$this->user["mail"] = $_COOKIE["usermail"];
		}
		if (is_null($this->user["mail"])) {
			$this->user["mail"] = $this->data["email"];
		}
		
		if (!is_null($_GET["userpasswd"])) {
			$this->user["enteredpasswd"] = md5($_GET["userpasswd"]);
		}
		if (is_null($this->user["enteredpasswd"])) {
			$this->user["enteredpasswd"] = $_COOKIE["userpasswd"];
		}
		if (is_null($this->user["enteredpasswd"])) {
			$this->user["enteredpasswd"] = md5($this->data["passwd"]);
		}
		
		if (!is_null($this->user["name"]) && ($this->security->isValidUsername($this->user["name"]))) {
			$this->user["isadmin"] = false;
			$this->security->readUserInfo();
			if (($_SERVER["REQUEST_METHOD"] <> $config->default_method) && (!$this->security->checkPassword())) {
				$this->user["rights"] = $config->unauthorized_user_rights;
			}
		} elseif ($_SERVER["REQUEST_METHOD"] <> $config->default_method) {
			$this->user["rights"] = $config->unauthorized_user_rights;
		}
		
		if (($_SERVER["REQUEST_METHOD"] == $config->default_method) && ($this->module == "auth") && (!is_null($this->user["name"])) && ($this->security->isValidUsername($this->user["name"]))) {
			$this->user["name"]   		= $this->data["name"];
			$this->user["passwd"] 		= md5($this->data["passwd"]);
			$this->user["mail"]		= $this->data["email"];
			$this->language			= $this->data["language"];
			$this->module			= $config->default_module;
//
			if ($this->security->readUserInfo()) {
				if (!$this->security->checkPassword()) {
					$this->user["passwd"] = "";
				}
			} else {
				$this->user["rights"] = $config->default_user_rights;
				if ($config->auto_add_new_users) {
					$this->security->addUserInfo();
				}
			}
		} elseif (($this->module == "unauth") && (!is_null($this->user["name"]))) {
			$this->user["name"]   		= "";
			$this->user["passwd"]	 	= "";
			$this->user["mail"]		= "";
			$this->user["rights"]		= $config->unauthorized_user_rights;
			$this->module			= $config->default_module;
//
		}
		
		if ((is_null($this->theme)) || (!$config->use_visual_themes)) {
			$this->theme = $config->default_theme;
		}
		
		if ((is_null($this->style)) || (!$config->use_visual_styles)) {
			$this->style = $config->default_style;
		}
		
		if (is_null($this->language)) {
			$this->language = $config->default_language;
		}
		
		if (is_null($this->module)) {
			$this->module   = $_GET["module"];
		}
		
		if ($this->module == "auth") {
			$this->module	= $config->default_module;
		} elseif ($this->module == "unauth") {
			$this->module	= $config->default_module;
			$this->user["rights"]= $config->unauthorized_user_rights;
		}
		
		$config->default_locale 		= $config->default_locales[$this->language];
		$config->default_locale_short		= $config->default_locales_short[$this->language];
		$config->default_export_locale		= $config->default_export_locales[$this->language];
		$config->default_safe_locale 		= $config->default_safe_locales[$this->language];
		
		setlocale(LC_ALL, $config->default_locale);
		
		if (is_null($this->action)) {
			$this->action   = $_GET["action"];
		}
		
		if ($this->action == "save") {
			$this->action = "show";
			$this->save = true;
		}
		
		if (is_null($this->sub)) {
			$this->sub = $_GET["sub"];
		}
		if (is_null($this->category)) {
			$this->category = $_GET["category"];
		}
		if (is_null($this->id)) {
			$this->id = $_GET["id"];
		}
		
		if (is_null($this->board)) {
			$this->board = $_GET["board"];
		}
		if (is_null($this->board)) {
			$this->board = 1;
		}
		if (is_null($this->tid)) {
			$this->tid = $_GET["tid"];
		}
		
		if (($this->module == "comments") && ($this->action == "show") && (is_null($this->sub)) && (!is_null($this->id)) && (is_null($this->tid))) {
			$this->tid = $this->id;
		}
		
		if (is_null($this->key)) {
			$this->key = $_GET["key"];
		}
		if (is_null($this->date)) {
			$this->date = $_GET["date"];
		}
		
		if (($this->module == "comments") && (is_null($this->action)) && (is_null($this->tid))) {
			$this->action = "subjects";
		}

		$config->comments_data_path = $config->data_path."/comments/".$this->board."/".$this->tid;
		$config->counters_data_path = $config->data_path."/comments/".$this->board."/counters";
		
		if (!is_null($this->key)) {
			$this->ids = $this->utils->getKeyIDs($this->module, $this->key);
		}
		
		if (is_null($this->user["rights"])) {
			$this->user["rights"] = $config->unauthorized_user_rights;
		}
		
		if ((!in_array($this->module, $config->ngine_modules)) && (!in_array($this->module, $config->ngine_invisible_modules))) {
			$this->module = $config->ngine_modules[1];
		}
		
		if (!is_null($this->date)) {
			$date = split("\.", $this->date);
			$this->year  = $date[2];
			$this->month = $date[1];
			$this->day   = $date[0];
		} elseif (!is_null($this->mounth)) {
			$month = split("\.", $this->mounth);
			$this->year  = $month[1];
			$this->month = $month[0];
			$this->day   = "01";
		} else {
			$this->year  = date("Y", time());
			$this->month = date("n", time());
			$this->day = date("j", time());
		
			$this->month = (strlen($this->month)==1?"0".$this->month:$this->month);
		
			if (($config->show_all_mounth) && (is_null($this->key)) && (is_null($this->id))) {
				$this->mounth = $this->month.".".$this->year;
				if ((is_null($this->date)) && (is_null($this->sub))) {
					$this->sub = "all";
				}
			}
		}

		$this->month = (strlen($this->month)==1?"0".$this->month:$this->month);

		if ($config->use_calendars) {
			$this->days = array();
			$this->utils->getCalendarDays();
		}

		if ((is_null($this->sub)) && ($this->first == 0) && (is_null($this->id))) {
			$this->sub = "last";
		}

		if (is_null($this->first)) { $this->first = $_GET["first"]; }
		if (is_null($this->first)) { $this->first = 0; }

		if (is_null($this->count)) { $this->count = $_GET["count"]; }
		if (is_null($this->count)) { $this->count = $config->default_count; }

		if (!is_null($this->ids)) {
			$this->count = sizeof(explode("|", $this->ids));
			$this->sub = "all";
		}

		if (is_null($this->module)) { $this->module = $config->default_module; }
		if (is_null($this->action)) { $this->action = $config->default_action; }

		if ((!is_null($this->key)) || (!is_null($this->category)) || (!is_null($this->search)) || (!is_null($this->author))) {
			$config->topics_count_in_export = $config->max_count;
			$this->sub = "all";
		}
		
		if ((($this->action == "archive") || (in_array($this->action, $config->exporters_format)) || ($this->action == "search") || ($this->action == "author")) && ($this->sub != "all")) {
                        $this->sub = "";
			$this->first = $config->default_count;
			$config->topics_count_in_export = $this->count = $config->max_count;
		}

		if ((($this->action == "archive") || (in_array($this->action, $config->exporters_format)) || ($this->action == "search") || ($this->action == "author")) && ($this->sub == "all")) {
			$this->first = 0;
			$config->topics_count_in_export = $this->count = $config->max_count;
		}

		if ((($this->action == "show") || (in_array($this->action, $config->exporters_format)) || ($this->action == "search") || ($this->action == "author")) && ($this->sub == "last")) {
			$this->first = 0;
			$config->topics_count_in_export = $this->count = ($this->count <> $config->default_count)?$this->count:(in_array($this->action, $config->exporters_format)?$config->topics_count_in_export:$config->default_count);
		}

		// set cookies
		$lifetime = time()+(((3600*24)*365)*10);
		setcookie("theme", $this->theme, $lifetime, "/");
		setcookie("style", $this->style, $lifetime, "/");
		setcookie("username", $this->user["name"], $lifetime, "/");
		setcookie("usermail", $this->user["mail"], $lifetime, "/");
		setcookie("userpasswd", $this->user["passwd"], $lifetime, "/");
		setcookie("language", $this->language, $lifetime, "/");

		write2log($this->action." request in module ".$this->module);

		if ($this->action == "rss20") {
			$this->action = "show";
			if (($config->remake_exports_at_request) || (!file_exists($config->export_data_path."/".$this->module.".rss.20.xml"))) {
				$this->core->makeRSS($this->module);
			}
			$this->utils->setCounter(true);
			header("Content-Type", "application/rss+xml");
			header("Location: /".$config->export_data_path."/".$this->module.".rss.20.xml");
		} elseif ($this->action == "atom03") {
			$this->action = "show";
			if (($config->remake_exports_at_request) || (!file_exists($config->export_data_path."/".$this->module.".atom.03.xml"))) {
				$this->core->makeATOM($this->module);
			}
			$this->utils->setCounter(true);
			header("Content-Type", "application/rss+xml");
			header("Location: /".$config->export_data_path."/".$this->module.".atom.03.xml");
		}

		if ($config->import_from_opml) {
			$this->utils->parseOPML(true);
		}

	}
	
	function translateHRURL($str) {
		$config  = $this->_owner->getConfiguration();

		if (strpos_x($str, "=") === false) {
			
			$elements = split("\/", $str); $i = 0;
			
			while ($i < sizeof($elements)) {

                                $elements[$i] = str_replace(" ", "", urldecode($elements[$i]));

				if (preg_match($config->modules_words_match, $elements[$i])) { // modules
					$this->module = $elements[$i];
					if ($this->module == "theme") {
						$this->module = $config->default_module;
						$this->theme = $elements[$i+1];
						$i++; $i++; continue;
					}
					if ($this->module == "style") {
						$this->module = $config->default_module;
						$this->style = $elements[$i+1];
						$i++; $i++; continue;
					}
					if ($this->module == "language") {
						$this->module = $config->default_module;
						$this->language = $elements[$i+1];
						$i++; $i++; continue;
					}
				}
				if (preg_match($config->actions_words_match, $elements[$i])) { // actions
					$this->action = $elements[$i];
					if ($this->action == "key") {
						$this->action = "show"; $this->key = urldecode($elements[$i+1]);
						$i++; $i++; continue;
					}
					if ($this->action == "category") {
						$this->action = "show"; $this->category = urldecode($elements[$i+1]);
						$i++; $i++; continue;
					}
					if ($this->action == "search") {
						$this->action = "show"; $this->search = urldecode($elements[$i+1]);
						$i++; $i++; continue;
					}
					if ($this->action == "author") {
						$this->action = "show"; $this->author = urldecode($elements[$i+1]);
						$i++; $i++; continue;
					}
				}
				if (preg_match($config->subactions_words_match, $elements[$i])) { // subactions
					$this->sub = $elements[$i];
				}
				if (preg_match("/^\d{1,2}\.\d{2}\.\d{2,4}$/", $elements[$i])) { // date
					$this->date = $elements[$i];
				}
				if (preg_match("/^\d{1,2}\.\d{2,4}$/", $elements[$i])) { // date
					$this->mounth = $elements[$i];
				}
				if ((preg_match("/^s(\d+\,?)+$/", $elements[$i])) || (preg_match("/^(\d+\,?)+$/", $elements[$i]))) {  // ids
					$this->ids = "|".str_replace(",", "|", preg_replace("/^s/i", "", str_replace(" ", "", $elements[$i])))."|";
				}
				if ((preg_match("/^i\d+/i", $elements[$i])) || (preg_match("/^\d+$/", $elements[$i]))) {  // id
					$this->id = preg_replace("/^i/i", "", $elements[$i]);
					
					if (($this->module == "comments") && ($this->action == "show") && (is_null($this->sub)) && (!is_null($this->id))) {
						$this->tid = $this->id;
					}
				}
				if (preg_match("/^t\d+/i", $elements[$i])) {  // tid
					$this->tid = preg_replace("/^t/i", "", $elements[$i]);
				}
				if (preg_match("/^p\d+/i", $elements[$i])) {  // pid
					$this->pid = preg_replace("/^p/i", "", $elements[$i]);
				}
				if (preg_match("/^b\d+/i", $elements[$i])) {  // board
					$this->board = preg_replace("/^b/i", "", $elements[$i]);
				}
				if (preg_match("/^f\d+/i", $elements[$i])) {  // first
					$this->first = preg_replace("/^f/i", "", $elements[$i]);
				}
				if (preg_match("/^c\d+/i", $elements[$i])) {  // count
					$this->count = preg_replace("/^c/i", "", $elements[$i]);
				}
			$i++;
			}
		} else {
			$this->module = $_GET["module"];
		}
	}

}

?>
