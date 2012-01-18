<?php

class cGizmosContent extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
		$this->_owner->getSession()->gizmo_keys = str_replace("\n", "|", trim($this->_owner->getSession()->utils->getKeysList($this->_owner->getSession()->module, false)));
		$this->_owner->getSession()->board = 2;
		$this->_owner->getConfiguration()->counters_data_path = $this->_owner->getConfiguration()->data_path."/comments/".$this->_owner->getSession()->board."/counters";
		if ((!is_null($this->_owner->getSession()->key)) && (!preg_match("/".$this->_owner->getSession()->key."/ui", $this->_owner->getSession()->gizmo_keys))) {
			$this->_owner->getSession()->action = "add";
		}
	}

	protected function append() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		if ($session->action == "bookmarks") {
			$topic = "";
			$session->storage->setSource($config->gizmo_data_path);
			$data = $session->storage->getData($session->id);
			$topic = trim($data[6]);
			$link_id = trim($data[0]);
			
			if (!empty($topic)) {
				$session->storage->setSource($config->bookmarks_data_path."/".trim($session->user['name']));
				$found = $session->storage->getIDbyData($config->data_delimiter.$topic.$config->data_delimiter);
				
				if ($found <= 0) {
					$str = ($session->storage->getLastId()+1).$config->data_delimiter.$topic.$config->data_delimiter.$session->module.$config->data_delimiter.$session->utils->makeHRURL("?module=".$session->module."&id=".$link_id).$config->data_delimiter.$config->data_delimiter.$config->data_delimiter;
					$session->storage->Append(explode($config->data_delimiter, $str));

					write2log("bookmark ".$session->id." added");
				}
				header("Location: ".$session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"));
			}
		} else {
			if (!(($session->security->canUser($session->module, $config->right_to_write)) || ($session->user['isadmin']))) {
				exit;
			}
			
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				
				$session->plugins->execHook(cHooks::beforePostFormProcess, &$session->data);

				$session->storage->setSource($config->gizmo_data_path);
				$session->id = ($session->storage->getLastID())+1;
				
				while ($session->utils->isLockedID($session->module, $session->id)) {
					$session->id++;
				}
				
				$session->utils->lockID($session->module, $session->id);
				
				$name  = $session->data['name'];
				$email = $session->data['email'];
				
				$text = str_replace("\n", "<br />", str_replace("\r", "", $session->data['text']));
				
				$keys = strip_tags(str_replace("\n", "", str_replace("\r", "", $session->data['keys'])));
				$topic = strip_tags($session->data['topic']);
				$session->gizmo['category'] = $session->data['category'];
				$url1 = $session->data['url1'];
				$url_name1 = $session->data['url_name1'];
				$url2 = $session->data['url2'];
				$url_name2 = $session->data['url_name2'];
				
				$session->post_err = NULL;
				
				if (!$name) {
					$session->post_err .= $i18n->errors['noname'];
				}
				
				if (!$text) {
					$session->post_err .= $i18n->errors['notext'];
				}
				
				if (!$topic) {
					$session->post_err .= $i18n->errors['nosubj'];
				}
				
				$email_ok = eregi("^([_\.0-9a-z-]+@)([0-9a-z][0-9a-z-]+\.)+([a-z]{2,4})\$", $email);
				
				if (!$email_ok) {
					$session->post_err .= $i18n->errors['noemail'];
				}
				
				$session->plugins->execHook(cHooks::afterPostFormProcess, &$session->data);
				if (is_null($session->post_err)) {
				
					if ((!empty($url1)) && (!empty($url_name1))) {
						$url_str1 = $url_name1.",".$url1;
					}
					
					if ((!empty($url2)) && (!empty($url_name2))) {
						$url_str2 = $url_name2.",".$url2;
					}
					
					if ((!empty($url_str1)) && (!empty($url_str2))) {
						$url_str = $url_str1.";".$url_str2;
					} else {
						$url_str = $url_str1;
					}
					
					$text = $session->formatter->replacePermanentlyTags($text);
					$str = explode($config->data_delimiter, $session->id.$config->data_delimiter.$session->gizmo['category'].$config->data_delimiter.time().$config->data_delimiter.time().$config->data_delimiter.$name.",".$email.$config->data_delimiter.$url_str.$config->data_delimiter.$topic.$config->data_delimiter.$text.$config->data_delimiter.$keys.$config->data_delimiter);
					
					$session->plugins->execHook(cHooks::beforeSavePost, &$str);
					$session->storage->Append($str);
					$session->plugins->execHook(cHooks::afterSavePost, &$str);
					
					$session->core->makeExports($session->module);
					$session->core->remakeKeys($session->module);
				}
				
				$session->utils->unlockID($session->module, $session->id);
				
				write2log("post ".$session->id." added");
				
			} else {
				$session->data['name']  = $session->data['email'] = $session->data['notes'] = '';
			}
		}
	}

	protected function change() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
	
		if (!(($session->security->canUser($session->module, $config->right_to_change)) || ($session->user['isadmin']))) {
			exit;
		}
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			$session->plugins->execHook(cHooks::beforePostFormProcess, &$session->data);

			$session->storage->setSource($config->gizmo_data_path);
			$session->storage->Sort("CompareByID");

			while ($session->utils->isLockedID($session->module, $session->id)) {
			}

			$session->utils->lockID($session->module, $session->id);
			
			$name  = $session->data['name'];
			$email = $session->data['email'];
			
			$text = str_replace("\n", "<br />", str_replace("\r", "", $session->data['text']));
			
			$keys = strip_tags(str_replace("\n", "", str_replace("\r", "", $session->data['keys'])));
			$topic = strip_tags($session->data['topic']);
			$unixtime = $session->data['unixtime'];
			$category = trim(str_replace("\n", "", str_replace("\r", "", $session->data['category'])));
			$session->gizmo['category'] = trim(str_replace("\n", "", str_replace("\r", "", $session->data['category'])));
			$url1 = $session->data['url1'];
			$url_name1 = $session->data['url_name1'];
			$url2 = $session->data['url2'];
			$url_name2 = $session->data['url_name2'];
			
			$session->post_err = NULL;
			if (!$name) {
				$session->post_err .= $i18n->errors['noname'];
			}
			
			if (!$text) {
				$session->post_err .= $i18n->errors['notext'];
			}
			
			if (!$topic) {
				$session->post_err .= $i18n->errors['nosubj'];
			}
			
			$email_ok = eregi("^([_\.0-9a-z-]+@)([0-9a-z][0-9a-z-]+\.)+([a-z]{2,4})\$", $email);
			
			if (!$email_ok) {
				$session->post_err .= $i18n->errors['noemail'];
			}
			
			$session->plugins->execHook(cHooks::afterPostFormProcess, &$session->data);
			if (is_null($session->post_err)) {
				if ((!empty($url1)) && (!empty($url_name1))) {
					$url_str1 = $url_name1.",".$url1;
				}
			
				if ((!empty($url2)) && (!empty($url_name2))) {
					$url_str2 = $url_name2.",".$url2;
				}
				
				if ((!empty($url_str1)) && (!empty($url_str2))) {
					$url_str = $url_str1.";".$url_str2;
				} else {
					$url_str = $url_str1;
				}
				
				$text = $session->formatter->replacePermanentlyTags($text);
				
				$session->gizmo['category'] = $category;
				
				$str = explode($config->data_delimiter, $session->id.$config->data_delimiter.$session->gizmo['category'].$config->data_delimiter.$unixtime.$config->data_delimiter.time().$config->data_delimiter.$name.",".$email.$config->data_delimiter.$url_str.$config->data_delimiter.$topic.$config->data_delimiter.$text.$config->data_delimiter.$keys.$config->data_delimiter);
				
				$session->plugins->execHook(cHooks::beforeSavePost, &$str);
				$session->storage->Update($session->id, $str);
				$session->plugins->execHook(cHooks::afterSavePost, &$str);
				
				$session->core->makeExports($session->module);
				$session->core->remakeKeys($session->module);
				
				write2log("post ".$session->id." changed");
			}
			$session->utils->unlockID($session->module, $session->id);
		} else {
			$session->data['name']  = $session->data['email'] = $session->data['notes'] = '';
		}

	}

	protected function delete() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		if ($session->action == "bookmarks") {
			if ($session->security->canUser($session->module, $config->right_to_bookmark)) {
				$session->storage->setSource($config->bookmarks_data_path."/".trim($session->user['name']));
				
				$nnn = $session->storage->getData($session->id);
				$nnbookmarks = $nnn[0].$config->data_delimiter.$nnn[1].$config->data_delimiter.$nnn[2].$config->data_delimiter.$nnn[3].$config->data_delimiter."yes".$config->data_delimiter.$nnn[5].$config->data_delimiter.$nnn[6]."";
				
				$session->storage->Update($session->id, $nnbookmarks);
				
				write2log("bookmark ".$session->id." deleted");
			}
		} else {
			$session->storage->setSource($config->gizmo_data_path);
			$session->storage->Sort("CompareByID");
			
			while ($session->utils->isLockedID($session->module, $session->id)) {
			}
			$session->utils->lockID($session->module, $session->id);
			
			$str = $session->storage->getData($session->id);
			
			if ((!is_null($str)) && (($session->security->canUser($session->module, $config->right_to_delete) == 1) && ((strpos_x($str[3], trim($session->user['name'])) >= 0) || ($session->user['isadmin'])))) {
				$session->plugins->execHook(cHooks::beforeDeletePost, &$str);
				$session->plugins->execHook(cHooks::beforeSavePost, &$str);
				$str[9] = "yes"; $session->storage->Update($session->id, $str);
				$session->plugins->execHook(cHooks::afterSavePost, &$str);
				$session->plugins->execHook(cHooks::afterDeletePost, &$str);
			}
			
			$session->core->makeExports($session->module);
			$session->core->remakeKeys($session->module);
			
			$session->utils->unlockID($session->module, $session->id);
			
			write2log("post ".$session->id." deleted");
		}
	}

	protected function undelete() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		if ($session->action == "bookmarks") {
			if ($session->security->canUser($session->module, $config->right_to_bookmark)) {
				$session->storage->setSource($config->bookmarks_data_path."/".trim($session->user['name']));
				
				$nnn = $session->storage->getData($session->id);
				$nnbookmarks = $nnn[0].$config->data_delimiter.$nnn[1].$config->data_delimiter.$nnn[2].$config->data_delimiter.$nnn[3].$config->data_delimiter."".$config->data_delimiter.$nnn[5].$config->data_delimiter.$nnn[6]."";
				
				$session->storage->Update($session->id, $nnbookmarks);
				
				write2log("bookmark ".$session->id." undeleted");
			}
		} else {
			$session->storage->setSource($config->gizmo_data_path);
			$session->storage->Sort("CompareByID");
			
			while ($session->utils->isLockedID($session->module, $session->id)) {
			}
			$session->utils->lockID($session->module, $session->id);
			
			$str = $session->storage->getData($session->id);
			
			if ((!is_null($str)) && (($session->security->canUser($session->module, $config->right_to_delete) == 1) && ((strpos_x($str[3], trim($session->user['name'])) >= 0) || ($session->user['isadmin'])))) {
				$session->plugins->execHook(cHooks::beforeDeletePost, &$str);
				$session->plugins->execHook(cHooks::beforeSavePost, &$str);
				$str[9] = ""; $session->storage->Update($session->id, $str);
				$session->plugins->execHook(cHooks::afterSavePost, &$str);
				$session->plugins->execHook(cHooks::afterDeletePost, &$str);
			}
			
			$session->core->makeExports($session->module);
			$session->core->remakeKeys($session->module);
			
			$session->utils->unlockID($session->module, $session->id);
			
			write2log("post ".$session->id." undeleted");
		}	
	}

	function forKeys() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$result = false;

		$session->storage->setSource($config->gizmo_data_path);

		for ($i=1; $i <= $session->storage->getLastID(); $i++) {
			$data = $session->storage->getData($i);
			if ((!is_null($data)) && ($this->filterContent($data))) {
				$session->postdays[strftime("%m.%Y", $session->gizmo['unix_time'])] .= strftime("%d", $session->gizmo['unix_time'])."|";
			
				if ((strlen($session->gizmo['title']) >= $config->min_key_length) && ($config->keys_in_titles)) {
					$session->export_text .= $session->gizmo['id'].$config->data_delimiter.$session->gizmo['title']."\n";
				}
			
				$keys = split(";", $session->gizmo['keys']);
				foreach ($keys as $key) {
					$key = trim(chop($key));
					if (strlen($key) >= $config->min_key_length) {
						$session->export_text .= $session->gizmo['id'].$config->data_delimiter.$key."\n";
					}
				}
				// переворачиваем ключи для нормальной работы хронологии
				$temp = array_filter(explode("\n", $session->export_text));
				rsort($temp, SORT_NUMERIC);
				$session->export_text = implode("\n", $temp)."\n";
				//
				$result = true;
			}
		}
		return $result;
	}

	function forExport($a_format) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$format  = $this->_owner->getFormatter();

		$result = false;

		switch (trim($a_format)) {
			case "atom03" :
	
				$session->storage->setSource($config->gizmo_data_path);
				$session->storage->Sort("CompareByUpdate");

				for ($i = 1;$i <= (($config->topics_count_in_export > 0)? $config->topics_count_in_export : $session->storage->getLastID()); $i++) {
				
					if (($i > $config->max_count) || ($i > $session->storage->getLastID())) {
						break;
					}
	
					$data = $session->storage->getData($i);
					
					if ((!is_null($data)) && ($this->filterContent($data))) {
						$session->plugins->execHook(cHooks::beforeExportPost, &$data);
				
						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['text']);
						$session->gizmo['text'] = $format->Format($session->gizmo['text'], cFormatLevels::EXPORT, $session->gizmo['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['text']);
				
						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['title']);
						$session->gizmo['title'] = $session->formatter->Format($session->gizmo['title'], cFormatLevels::EXPORT, $session->gizmo['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['title']);
						
						$session->gizmo['keys'] = $session->utils->recodeStr($config->default_locale_short, $config->default_export_locale, stripslashes($session->gizmo['keys']));
						$session->gizmo['url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=".$session->module."&action=show&id=".$session->gizmo['id'])), ENT_NOQUOTES);
						$session->gizmo['comments_url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=comments&action=show&board=1&tid=".$session->gizmo['id'])), ENT_NOQUOTES);
						$session->gizmo['author_full_email'] = htmlspecialchars($session->gizmo['author_name']." <".$session->gizmo['author_email'].">");
						$session->gizmo['time'] = gmstrftime("%Y-%m-%dT%H:%M:%SZ", $session->gizmo['unix_time']);
						$session->gizmo['update_time'] = gmstrftime("%Y-%m-%dT%H:%M:%SZ", $session->gizmo['unix_utime']);
						$session->gizmo['tag'] = str_replace("http:", "", str_replace("/", "", $session->gizmo['url'])).",".strftime("%Y-%m-%d", $session->gizmo['unix_utime']).":tst.".$session->gizmo['unix_utime'];
						
						$session->plugins->execHook(cHooks::beforeExportThisPost, &$data);
						$session->export_text .= <<<RSSBODY
<entry>
  <title>{$session->gizmo['title']}</title>
  <link rel="alternate" type="text/html" href="{$session->gizmo['url']}" />
  <author>
   <name>{$session->gizmo['author_name']}</name>
   <email>{$session->gizmo['author_email']}</email>
  </author>
  <id>tag:{$session->gizmo['tag']}</id>
  <issued>{$session->gizmo['time']}</issued>
  <modified>{$session->gizmo['update_time']}</modified>
  <content type="text/html" mode="escaped">{$session->gizmo['text']}
RSSBODY;
						$session->plugins->execHook(cHooks::afterExportThisPost, &$data);
						$session->export_text .= "</content>\n</entry>";
						$session->plugins->execHook(cHooks::afterExportPost, &$data);
					}
					$result = true;
				}
				break;
				
			case "rss20" :
				$session->storage->setSource($config->gizmo_data_path);
				$session->storage->Sort("CompareByUpdate");

				setlocale(LC_TIME, "C");
				
				for ($i = 1;$i <= (($config->topics_count_in_export > 0)? $config->topics_count_in_export : $session->storage->getLastID()); $i++) {
				
					if (($i > $config->max_count) || ($i > $session->storage->getLastID())) {
						break;
					}
					
					$data = $session->storage->getData($i);
					
					if ((!is_null($data)) && ($this->filterContent($data))) {
						$session->plugins->execHook(cHooks::beforeExportPost, &$data);
				
						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['text']);
						$session->gizmo['text'] = $format->Format($session->gizmo['text'], cFormatLevels::EXPORT, $session->gizmo['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['text']);

						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['title']);
						$session->gizmo['title'] = $session->formatter->Format($session->gizmo['title'], cFormatLevels::EXPORT, $session->gizmo['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['title']);

						$session->gizmo['keys'] =  $session->utils->recodeStr($config->default_locale_short, $config->default_export_locale, stripslashes($session->gizmo['keys']));
						$session->gizmo['url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=".$session->module."&action=show&id=".$session->gizmo['id'])), ENT_NOQUOTES);
						$session->gizmo['comments_url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=comments&action=show&board=".$session->board."&tid=".$session->gizmo['id'])), ENT_NOQUOTES);
						$session->gizmo['author_full_email'] = htmlspecialchars($session->gizmo['author_name']." <".$session->gizmo['author_email'].">");
						$session->gizmo['time'] = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $session->gizmo['unix_utime']);
						
						$session->plugins->execHook(cHooks::beforeExportThisPost, &$data);
						$session->export_text .= <<<RSSBODY

<item>
<title>{$session->gizmo['title']}</title>
<link>{$session->gizmo['url']}</link>
<comments>{$session->gizmo['comments_url']}</comments>
<author>{$session->gizmo['author_full_email']}</author>
<guid isPermaLink="true">{$session->gizmo['url']}</guid>
<pubDate>{$session->gizmo['time']}</pubDate>
<description>{$session->gizmo['text']}
RSSBODY;
						$session->plugins->execHook(cHooks::afterExportThisPost, &$data);
						$session->export_text .= "</description>\n</item>";
						$session->plugins->execHook(cHooks::afterExportPost, &$data);
					}
					$result = true;
				}
				setlocale(LC_TIME, $config->default_locale);
				break;
				
			default :
				break;
		}

		return $result;

	}

	function forComments() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		$session->storage->setSource($config->gizmo_data_path);
		$data = $session->storage->getData($session->tid, false);
	
		require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/maintance.php");
	
		if ((!is_null($data)) && ($this->filterContent($data))) {
			$session->post_author = $session->gizmo['author_name']." <".$session->gizmo['author_email'].">";
			$author_name = $session->gizmo['author_name'];
			$author_email = $session->gizmo['author_email'];
			$session->all_title = $session->gizmo['title'];
			
			$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['text']);
			$session->gizmo['quoted'] = $session->formatter->Format($session->gizmo['text'], cFormatLevels::QUOTE, $session->gizmo['id'], false);
			$session->gizmo['text'] = $session->formatter->Format($session->gizmo['text'], cFormatLevels::COMMENT, $session->gizmo['id']);
			$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['text']);
			
			$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['title']);
			$session->gizmo['title'] = $session->formatter->Format($session->gizmo['title'], cFormatLevels::COMMENT, $session->gizmo['id']);
			$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['title']);

			$session->plugins->execHook(cHooks::beforeShowPost, &$session->gizmo);
			
			require($config->styles_modules_path."/".$session->style."/".$session->board_type."/".$session->action."/header.php");
			require($config->styles_modules_path."/".$session->style."/".$session->board_type."/".$session->action."/text.php");
			require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/".$session->board_type."/footer.php");
			
			$session->plugins->execHook(cHooks::afterShowPost, &$session->gizmo);
		}
	}

	protected function add() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if (($session->security->canUser($session->module, $config->right_to_write)) && (($_SERVER['REQUEST_METHOD'] <> 'POST') || (!is_null($session->post_err))))  {
			require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");
			require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/text.php");
		}
	}

	protected function show() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		write2log("try to show posts".(!is_null($session->key)?", key = ".$session->key:"").(!is_null($session->search)?", search = ".$session->search:"").(!is_null($session->id)?", id = ".$session->id:"").(!is_null($session->author)?", author = ".$session->author:"").(!is_null($session->category)?", category = ".$session->category:"").(!is_null($session->date)?", date = ".$session->date:"").(!is_null($session->mounth)?", mounth = ".$session->mounth:""));
		
		if (!in_array($session->sub, $config->no_maintances_in_subactions)) {
			require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/maintance.php");
		}

		$session->counters = $session->storage->getSource($config->counters_data_path);
		$session->counters->Sort("CompareByID");

		$session->storage->setSource($config->gizmo_data_path);
		$session->storage->Sort("CompareByUpdate");

		if (!is_null($session->id)) {
			$this->showByID($session->id, false);
		} elseif (!is_null($session->ids)) {
			$ids = split("\|", $session->ids);
			foreach ($ids as $id) {
				if (!empty($id)) {
					$this->showByID($id, false);
				}
			}
		} else {
			for ($i = ($session->first+1); $i <= ($session->first+$session->count); $i++) {
				if (($i > $config->max_count) || ($i > $session->storage->getLastID())) {
					break;
				}
				$this->showByID($i);
			}
		}
	}

	protected function archive() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		write2log("try to show posts".(!is_null($session->key)?", key = ".$session->key:"").(!is_null($session->search)?", search = ".$session->search:"").(!is_null($session->id)?", id = ".$session->id:"").(!is_null($session->author)?", author = ".$session->author:"").(!is_null($session->category)?", category = ".$session->category:"").(!is_null($session->date)?", date = ".$session->date:"").(!is_null($session->mounth)?", mounth = ".$session->mounth:""));

		if (!in_array($session->sub, $config->no_maintances_in_subactions)) {
			require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/maintance.php");
		}

		$session->counters = $session->storage->getSource($config->counters_data_path);
		$session->counters->Sort("CompareByID");

		$session->storage->setSource($config->gizmo_data_path);
		$session->storage->Sort("CompareByUpdate");

		if (!is_null($session->id)) {
			$this->showByID($session->id, false);
		} elseif (!is_null($session->ids)) {
			$ids = split("\|", $session->ids);
			foreach ($ids as $id) {
				if (!empty($id)) {
					$this->showByID($id, false);
				}
			}
		} else {
			for ($i = ($session->first+1); $i <= ($session->first+$session->count); $i++) {
				if (($i > $config->max_count) || ($i > $session->storage->getLastID())) {
					break;
				}
				$this->showTitleByID($i);
			}
		}
	}

	protected function showByID($a_id = 0, $byindex = true) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
	
		$session->storage->setSource($config->gizmo_data_path);
		$data = $session->storage->getData($a_id, $byindex);
		
		if ((!is_null($data)) && ($this->filterContent($data))) {

			$cnt = $session->counters->getData($session->gizmo['id'], false);
			$comments_count = (!empty($cnt[1]))?$cnt[1]:0;
			if ($session->security->canUser($session->module, $config->right_to_read))  {
			
				if (!empty($session->gizmo['del'])) {
					$session->gizmo['title'] = "--".$session->gizmo['title']."--";
				}
				
				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['text']);
				$session->gizmo['text'] = $session->formatter->Format($session->gizmo['text'], cFormatLevels::SHOW, $session->gizmo['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['text']);
				
				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['title']);
				$session->gizmo['title'] = $session->formatter->Format($session->gizmo['title'], cFormatLevels::SHOW, $session->gizmo['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['title']);

				$session->plugins->execHook(cHooks::beforeShowPost, &$session->gizmo);

				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/text.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/footer.php");
				
				$session->plugins->execHook(cHooks::afterShowPost, &$session->gizmo);

				write2log("posts #".$session->gizmo['id']." showed successfully");
			}
		}
	}
	
	protected function showTitleByID($a_id = 0, $byindex = true) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		$session->storage->setSource($config->gizmo_data_path);
		$data = $session->storage->getData($a_id, $byindex);

		if ((!is_null($data)) && ($this->filterContent($data))) {

			$cnt = $session->counters->getData($session->gizmo['id'], false);
			$comments_count = (!empty($cnt[1]))?$cnt[1]:0;
			if ($session->security->canUser($session->module, $config->right_to_read))  {

				if (!empty($session->gizmo['del'])) {
					$session->gizmo['title'] = "--".$session->gizmo['title']."--";
				}

				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['text']);
				$session->gizmo['text'] = $session->formatter->Format($session->gizmo['text'], cFormatLevels::SHOW, $session->gizmo['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['text']);

				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->gizmo['title']);
				$session->gizmo['title'] = $session->formatter->Format($session->gizmo['title'], cFormatLevels::SHOW, $session->gizmo['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->gizmo['title']);

				$session->plugins->execHook(cHooks::beforeShowPost, &$session->gizmo);

				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");

				$session->plugins->execHook(cHooks::afterShowPost, &$session->gizmo);

				write2log("posts #".$session->gizmo['id']." showed successfully");
			}
		}
	}

	protected function edit() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		write2log("try to change post #".$session->id);
		
		$session->storage->setSource($config->gizmo_data_path);
		$data = $session->storage->getData($session->id);
			
		if ((!is_null($data)) && ($this->filterContent($data))) {

			$addons = split(";", $session->gizmo['addons']);
			$addon1 = split(",", $addons[0]); $session->gizmo['url_name1'] = $addon1[0]; $session->gizmo['url1'] = $addon1[1];
			$addon2 = split(",", $addons[1]); $session->gizmo['url_name2'] = $addon2[0]; $session->gizmo['url2'] = $addon2[1];

			if ($session->security->canUser($session->module, $config->right_to_change) == 1)  {
				$session->gizmo['text'] = $session->formatter->Format($session->gizmo['text'], cFormatLevels::EDIT, $session->gizmo['id']);
				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/text.php");
			}
		}
	}

	protected function keys() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		write2log("try to show keys");
		if (!in_array($session->sub, $config->no_maintances_in_subactions)) {
			require($config->styles_modules_path."/".$session->style."/".$session->module."/show/maintance.php");
		}
		require($config->styles_modules_path."/".$session->style."/keys/all_header.php");
		
		if ($config->use_keywords) {
			if ($session->sub == "all") {
				$session->utils->printKeysPage(trim(implode(" ", $config->ngine_modules)));
			} else {
				$session->utils->printKeysPage($session->module);
			}
		} else {
			header("Location: /");
		}
		
		require($config->styles_modules_path."/".$session->style."/keys/all_footer.php");
		write2log("keys showed successfully");
	}
	
	protected function bookmarks() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		write2log("try to show bookmarks");
		if (!in_array($session->sub, $config->no_maintances_in_subactions)) {
			require($config->styles_modules_path."/".$session->style."/".$session->module."/show/maintance.php");
		}
		require($config->styles_modules_path."/".$session->style."/bookmarks/all_header.php");
		
		if ($config->use_bookmarks) {
			if ($session->sub == "all") {
				$session->utils->printBookmarksPage($config->bookmarks_by_modules[$session->module]." ".$session->user['name']);
			} else {
				$session->utils->printBookmarksPage($session->user['name']);
			}
		} else {
			header("Location: /");
		}		
		
		require($config->styles_modules_path."/".$session->style."/bookmarks/all_footer.php");
		write2log("bookmarks showed successfully");
	}

	function showContent() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if ((!is_null($session->sub) && (!in_array($session->sub, $config->subactions_allowed_to_select)))) {
			if (in_array($session->sub, get_class_methods(get_class($this)))) {
				$method = $session->sub;
				$this->$method();
			}
		}

		if (is_null($session->post_err)) {
			if ((!is_null($session->sub) && ($session->sub <> "all") && ($session->sub <> "archive")) && (($_SERVER['REQUEST_METHOD'] == 'POST'))) {
				header("Location: /".$session->utils->makeHRURL("?module=".$session->module."&action=".$session->action."&id=".$session->id));
			}
			
			if ($session->save) {
				header("Location: /".$session->utils->makeHRURL("?module=".$session->module."&action=change&sub=edit&id=".$session->id));
			}
		
		}

		if (in_array($session->action, get_class_methods(get_class($this)))) {
			$method = $session->action;
			$this->$method();
		}
	}

	protected function filterContent(&$data) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$session->gizmo['id'] = $data[0];
		$session->gizmo['category'] = $data[1];
		$session->gizmo['unix_time'] = $data[2];
		$session->gizmo['unix_utime'] = $data[3];
		$session->gizmo['date'] = strftime("%d.%m.%Y", $data[2]);
		$session->gizmo['mounth'] = strftime("%m.%Y", $data[2]);
		$session->gizmo['time'] = strftime("%H:%M:%S", $data[2]);
		$session->gizmo['udate'] = strftime("%d.%m.%Y", $data[3]);
		$session->gizmo['umounth'] = strftime("%m.%Y", $data[3]);
		$session->gizmo['utime'] = strftime("%H:%M:%S", $data[3]);
		$session->gizmo['author_full'] = split(",", $data[4]);
		$session->gizmo['author_name'] = $session->gizmo['author_full'][0];
		$session->gizmo['author_email'] = $session->gizmo['author_full'][1];
		$session->gizmo['addons'] = $data[5];
		$session->gizmo['title'] = stripslashes($data[6]);
		$session->gizmo['text'] = stripslashes($data[7]); 
		$session->gizmo['keys'] = stripslashes($data[8]);
		$session->gizmo['del'] = $data[9];

		$session->plugins->execHook(cHooks::beforeFilterContent, &$session->gizmo);

		if ((!is_null($session->id) && in_array($session->sub, $config->subactions_allowed_to_select)) && ($session->gizmo['id'] <> $session->id)) {
			return false;
		}

		if ((!is_null($session->ids) && in_array($session->sub, $config->subactions_allowed_to_select)) && (strpos_x($session->ids, "|".$session->gizmo['id']."|") === false)) {
			return false;
		}

		if ((!is_null($session->category)) && ($session->gizmo['category'] != $session->category)) {
			return false;
		}

		if ((!is_null($session->mounth)) && ($session->gizmo['mounth'] != $session->mounth)) {
			return false;
		}

		if ((!is_null($session->date)) && ($session->gizmo['date'] != $session->date)) {
			return false;
		}

		if ((!in_array($session->gizmo['category'], $config->categories_allowed_to_view[$session->module])) && !((trim($session->gizmo['author_name']) == trim($session->user['name'])) || ($session->user['isadmin']))) {
			return false;
		}

		if (!is_null($session->search)) {
			if ((!preg_match('/'.$session->search.'/ui', $session->gizmo['text'])) && (!preg_match('/'.$session->search.'/ui', $session->gizmo['keys'])) && (!preg_match('/'.$session->search.'/ui', $session->gizmo['title']))) {
				return false;
			} else {
				$session->gizmo['text'] = preg_replace('/'.$session->search.'/ui', "**$0**", $session->gizmo['text']);
			}
		}

		if (($session->action <> "edit") && ($session->action <> "add")) {
			if (!is_null($session->key)) {
				if (preg_match('/'.$session->key.'/ui', $session->gizmo['text'])) {
					$session->gizmo['text'] = preg_replace('/'.$session->key.'/ui', "**$0**", $session->gizmo['text']);
				}
			}
		}

		if ((!is_null($session->author)) && (!(trim($session->gizmo['author_name']) == trim($session->author)))) {
			return false;
		}

		if (!empty($session->gizmo['del']) && !(trim($session->gizmo['author_name']) == trim($session->user['name'])) && (!$session->user['isadmin'])) {
			return false;
		}

      		if (($session->action <> "edit") && ($session->action <> "add")) {
			$session->gizmo['text'] = $session->formatter->Format($session->gizmo['text'], cFormatLevels::GIZMO, $session->gizmo['id']);
      		}

		$session->plugins->execHook(cHooks::afterFilterContent, &$session->gizmo);

		return true;
	}
	
}

?>
