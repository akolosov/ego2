<?php

class cCommentsContent extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}
	
	protected function show() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		$format	 = $session->core->getFormatter();

		write2log("try to show comments for ".$session->board_name.", id #".$session->tid);
		
		$exporter = new $config->modules_to_classes[$session->board_type]($this->_owner);
		if (in_array("forComments", get_class_methods(get_class($exporter)))) {
			$exporter->forComments();
		}

		if (!$config->comment_form_at_down) {
			if (($session->security->canUser($session->board_type, $config->right_to_comment)) && ($config->use_comments)) {
				require($config->styles_modules_path."/".$session->style."/".$session->module."/add/header.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/add/text.php");
			}
		}
		
		$session->storage->setSource($config->comments_data_path);
		if ($config->comments_reverse_sort) {
			$session->storage->Reverse();
		}
		
		for($i = 1; $i <= ($session->storage->getlastID()); $i++) {
			$data = $session->storage->getData($i);
		
			if ((!is_null($data)) && ($this->filterContent($data))) {
				
				if (!empty($session->comment['del'])) {
					$session->comment['title'] = "--".$session->comment['title']."--";
				}
				
				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->comment['title']);
				$session->comment['title'] = $format->Format($session->comment['title'], cFormatLevels::SHOW, 0);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->comment['title']);

				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->comment['text']);
				$session->comment['text'] = $format->Format($session->comment['text'], cFormatLevels::SHOW, 0);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->comment['text']);
				
				$session->comment['quoted'] = $format->Format($session->comment['quoted'], cFormatLevels::QUOTE, 0, false);

				$session->plugins->execHook(cHooks::beforeShowPost, &$session->comment);

				if (empty($session->comment['del']) || (trim($session->comment['author_name']) == trim($session->user['name'])) || ($session->user['isadmin'])) {
			
					require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");
					require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/text.php");
					require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/footer.php");
					
					write2log("comment #".$session->comment['id']." showed successfully");
				}
				
				$session->plugins->execHook(cHooks::afterShowPost, &$session->comment);
			}
		}
		
		if ($config->comment_form_at_down) {
			if (($session->security->canUser($session->board_type, $config->right_to_comment)) && ($config->use_comments)) {
				require($config->styles_modules_path."/".$session->style."/".$session->module."/add/header.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/add/text.php");
			}
		}
		write2log("all comments showed successfully");
	
	}

	protected function subjects() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		write2log("try to show comment's subjects");
		require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");
		require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/text.php");
		require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/footer.php");
		write2log("comment's subjects showed successfully");	
	}
	
	protected function bookmarks() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		write2log("try to show bookmarks");
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
	
	protected function append() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		$format	 = $session->core->getFormatter();
		
		if ($session->action == "bookmarks") {
			$topic = "";
			$session->storage->setSource($config->blog_data_path);
			$data = $session->storage->getData($session->id);
			$topic = trim($data[6]);
			$link_id = trim($data[0]);
			
			if (!empty($topic)) {
				$session->storage->setSource($config->bookmarks_data_path."/".trim($session->user['name']));
				$found = $session->storage->getIDbyData($config->data_delimiter.$topic.$config->data_delimiter);
				
				if ($found <= 0) {
					$str = ($session->storage->getLastId()+1).$config->data_delimiter.$topic.$config->data_delimiter.$session->module.$config->data_delimiter.$session->utils->makeHRURL("?module=".$session->module."&board=".$session->board."&tid=".$session->tid).$config->data_delimiter.$config->data_delimiter.$config->data_delimiter;
					$session->storage->Append(explode($config->data_delimiter, $str));

					write2log("bookmark ".$session->id." added");
				}
				header("Location: ".$session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"));
			}
		} else {		
			if (!(($session->security->canUser($session->module, $config->right_to_write)) || ($session->user['isadmin']))) {
				exit;
			}
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
				$session->plugins->execHook(cHooks::beforePostFormProcess, &$session->data);
				
				$session->storage->setSource($config->comments_data_path);
				$session->id = ($session->storage->getLastID())+1;
				
				while ($session->utils->isLockedID($session->module, $session->board.".".$session->tid.".".$session->id)) {
					$session->id++;
				}
				
				$session->utils->lockID($session->module, $session->board.".".$session->tid.".".$session->id);
				
				$name  = trim($session->data['name']);
				$email = trim($session->data['email']);
				$text = str_replace("\n", "<br />", str_replace("\r", "", trim($session->data['text'])));
				$topic = trim($session->data['topic']);
				$subscribe = $session->data['subscribe'];
				
				$session->post_err = NULL;
				
				if (!$name) {
					$session->post_err .= $i18n->errors['noname'];
				}
				
				if (!$text) {
					$session->post_err .= $i18n->errors['notext'];
				}
				
				if (!$topic) {
					switch ($session->board) {
						case 1 : 
							$topic = (is_null($session->blog['title'])?$session->all_title:$session->blog['title']);
							break;
						case 2 : 
							$topic = (is_null($session->gizmo['title'])?$session->all_title:$session->gizmo['title']);
							break;
					}
				}
				
				if (!$topic) {
					$session->post_err .= $i18n->errors['nosubj'];
				}
				
				$email_ok = eregi("^([_\.0-9a-z-]+@)([0-9a-z][0-9a-z-]+\.)+([a-z]{2,4})\$", $email);
				
				if (!$email_ok) {
					if ($config->empty_email_in_comments) {
						$email = $config->phantom_email;
					} else {
						$session->post_err .= $i18n->errors['noemail'];
					}
				}
				
				//
				if (($session->plugins->execHook(cHooks::afterPostFormProcess, &$session->data)) && (is_null($session->post_err))) {
				
					$session->comment_text = $text = $session->formatter->replacePermanentlyTags($text);
					
					$str = explode($config->data_delimiter, $session->id.$config->data_delimiter.time().$config->data_delimiter."".$config->data_delimiter.$name.",".$email.$config->data_delimiter.$topic.$config->data_delimiter.$text.$config->data_delimiter);
					
					$session->plugins->execHook(cHooks::beforeSavePost, &$str);
					$session->storage->Append($str);
					$session->plugins->execHook(cHooks::afterSavePost, &$str);
					
					$session->storage->setSource($config->counters_data_path);
					
					$cnt = array();
					$aid = $session->storage->getIDByData("^".$session->tid.$config->data_delimiter);
					if ($aid) {
						$cnt = $session->storage->getData($aid);
						$cnt[1]++; $cnt[3] = time();
						$session->storage->Update($aid, $cnt, true);
						$session->storage->Sort("CompareComments");
						$session->storage->Save();
					} else {
						$cnt[0] = $session->tid; $cnt[1] = 1; $cnt[2] = $topic; $cnt[3] = time();
						$session->storage->Append($cnt, true);
						$session->storage->Sort("CompareComments");
						$session->storage->Save();
					}
					
					$session->comment_author = $name." <".$email.">";
					
					if ((!empty($subscribe)) && ($email <> $config->phantom_email)) {
						$session->utils->addToNotifyList($session->board, $session->tid, $name." <".$email.">");
					}

					//�send by e-mail
					if (($config->send_email_to_author) && ($email <> $config->phantom_email)) {
					
						$post_authors = $session->utils->getNotifyList($session->board, $session->tid);
					
						if (!empty($post_authors)) {
							$post_authors .= ", ".cSiteConfig::OWNER_NAME." <".cSiteConfig::OWNER_EMAIL.">";
						} else {
							$post_authors = cSiteConfig::OWNER_NAME." <".cSiteConfig::OWNER_EMAIL.">";
						}
					
						write2log("try to send comments by email to ".$post_authors);
						
						$message = iconv($config->default_locale_short, $config->default_safe_locale, "На сайте \"".$config->site_name."\" читатели прокоментировали интересующую Вас тему.\nМожете прочитать коментарии и оставить свои, проследовав по ссылке ".$session->utils->makeHRURL($config->site_url."?module=comments&action=show&tid=".$session->tid."&board=".$session->board."#".$session->id)."\n\n");
						if ($config->send_text_with_email) {
							$message .= iconv($config->default_locale_short, $config->default_safe_locale, $i18n->author.": ".$session->comment_author."\n");
							$message .= "---------------------------------------------------------8<--------------------------------------------------\n";
							$message .= $format->Format($session->comment_text, cFormatLevels::EMAIL, 0, false);
							$message .= "\n--------------------------------------------------------->8---------------------------------------------------\n\n";
						}
						$message .= "---\n".$config->ngine_name." v".$config->ngine_version;
						
						if (mail($session->utils->recodeStr($config->default_locale_short, $config->default_safe_locale, $post_authors), $session->utils->encodeEMail(iconv($config->default_locale_short, $config->default_safe_locale, "Добавление коментария"), $config->default_safe_locale), $message, "From: ".$session->utils->encodeEMail(iconv($config->default_locale_short, $config->default_safe_locale, $config->site_name), $config->default_safe_locale)." <".$config->site_email.">"."\n"."Content-Type: text/plain; charset=".$config->default_safe_locale."\n"."X-Mailer: ".$config->ngine_name." v".$config->ngine_version."\n\r")) {
							write2log("comments sent by email successfully");
						} else {
							write2log("comments sent by email failed");
						}
						
						if (($config->debug_mode) && ($config->use_log)) {
							write2log("From : ".$config->site_email);
							write2log("To   : ".$post_authors);
							write2log($message);
						}
					}
				}
				
				$session->utils->unlockID($session->module, $session->board.".".$session->tid.".".$session->id);
				
				write2log("comment ".$session->board.".".$session->tid.".".$session->id." added");
				
			} else {
				$session->data['name'] = $session->data['email'] = $session->data['notes'] = '';
			}
		}
	}
	
	protected function delete() {
//
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if ($session->action == "bookmarks") {
			if ($session->security->canUser($session->module, $config->right_to_bookmark)) {
				$session->storage->setSource($config->bookmarks_data_path."/".trim($session->user['name']));
				
				$nnn = $session->storage->getData($session->id);
				$nnbookmarks = $nnn[0].$config->data_delimiter.$nnn[1].$config->data_delimiter.$nnn[2].$config->data_delimiter.$nnn[3].$config->data_delimiter."yes".$config->data_delimiter.$nnn[5].$config->data_delimiter.$nnn[6]."";
				
				$session->storage->Update($session->id, $nnbookmarks);
				
				write2log("bookmark ".$session->id." deleted");
			}
		} else {		
			$session->storage->setSource($config->comments_data_path);
			$session->storage->Sort("CompareByID");
			
			while ($session->utils->isLockedID($session->module, $session->board.".".$session->tid.".".$session->id)) {
			}
			$session->utils->lockID($session->module, $session->board.".".$session->tid.".".$session->id);
			
			$str = $session->storage->getData($session->id);

			if (($session->security->canUser($session->module, $config->right_to_delete)) && ((strpos_x($str[3], trim($session->user['name'])) > 0) || ($session->user['isadmin']))) {
				$str[6] = "yes"; $deleted = true;
				$session->plugins->execHook(cHooks::beforeSavePost, &$str);
				$session->storage->Update($session->id, $str);
				$session->plugins->execHook(cHooks::afterSavePost, &$str);
				
			}
			
			$session->utils->unlockID($session->module, $session->board.".".$session->tid.".".$session->id);
			
			$session->storage->setSource($config->counters_data_path);

			if ((!is_null($session->tid)) && ($deleted)) {
				$cnt = $session->storage->getData($session->tid, false);
				$cnt[1]--; $cnt[3] = time();
				write2log("comments count for ".$session->board.".".$cnt[0]." = ".$cnt[1]);
				$session->storage->Update($session->tid, $cnt, true, false);
				$session->storage->Sort("CompareComments");
				$session->storage->Save();
			}
			
			write2log("comment ".$session->board.".".$session->tid.".".$session->id." deleted");
			write2log("comment counter for ".$session->board.".".$session->tid.".".$session->id." decremented");
		}
	}
	
	protected function undelete() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if ($session->action == "bookmarks") {
			if ($session->security->canUser($session->module, $config->right_to_bookmark)) {
				$session->storage->setSource($config->bookmarks_data_path."/".trim($session->user['name']));
				
				$nnn = $session->storage->getData($session->id);
				$nnbookmarks = $nnn[0].$config->data_delimiter.$nnn[1].$config->data_delimiter.$nnn[2].$config->data_delimiter.$nnn[3].$config->data_delimiter."".$config->data_delimiter.$nnn[5].$config->data_delimiter.$nnn[6]."";
				
				$session->storage->Update($session->id, $nnbookmarks);
				
				write2log("bookmark ".$session->id." undeleted");
			}
		} else {		
			$session->storage->setSource($config->comments_data_path);
			$session->storage->Sort("CompareByID");
			
			while ($session->utils->isLockedID($session->module, $session->board.".".$session->tid.".".$session->id)) {
			}
			$session->utils->lockID($session->module, $session->board.".".$session->tid.".".$session->id);
			
			$str = $session->storage->getData($session->id);
			
			if (($session->security->canUser($session->module, $config->right_to_delete) == 1) && ((strpos_x($str[3], trim($session->user['name'])) > 0) || ($session->user['isadmin']))) {
				$str[6] = ""; $undeleted = true;
				
				$session->plugins->execHook(cHooks::beforeSavePost, &$str);
				$session->storage->Update($session->id, $str);
				$session->plugins->execHook(cHooks::afterSavePost, &$str);
			}
			
			$session->storage->setSource($config->counters_data_path);
			$session->storage->Sort("CompareByID");

			if ((!is_null($session->tid)) && ($undeleted)) {
				$cnt = $session->storage->getData($session->tid, false);
				$cnt[1]++; $cnt[3] = time();
				write2log("comments count for ".$session->board.".".$cnt[0]." = ".$cnt[1]);
				$session->storage->Update($session->tid, $cnt, true, false);
				$session->storage->Sort("CompareComments");
				$session->storage->Save();
			}

			$session->utils->unlockID($session->module, $session->board.".".$session->tid.".".$session->id);
			
			write2log("comment counter for ".$session->board.".".$session->tid.".".$session->id." decremented");
			write2log("comment ".$session->board.".".$session->tid.".".$session->id." undeleted");
		}
	}

	function showContent() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		$session->storage->setSource($config->boards_data_path);
		$buffer = $session->storage->getData($session->board);
		$session->board_name = $buffer[1];
		$session->board_type = $buffer[2];

		if ((is_null($session->tid)) && ($session->action <> "subjects") && ($session->action) <> "bookmarks") {
			$session->action = "subjects";
		}
		
		if ((!is_null($session->sub) && (!in_array($session->sub, $config->subactions_allowed_to_select)))) {
			if (in_array($session->sub, get_class_methods(get_class($this)))) {
				$method = $session->sub;
				$this->$method();
			}
		}

		if (is_null($session->post_err)) {
			if ((!is_null($session->sub) && ($session->sub <> "all") && ($session->sub <> "archive")) && (($_SERVER['REQUEST_METHOD'] == 'POST') || ($session->action == "bookmarks"))) {
				header("Location: /".$session->utils->makeHRURL("?module=".$session->module."&action=".$session->action."&board=".$session->board."&tid=".$session->tid));
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
				
		$session->comment['id'] = $data[0];
		$session->comment['unix_time'] = $data[1];
		$session->comment['date'] = strftime("%d.%m.%Y", $data[1]);
		$session->comment['time'] = strftime("%H:%M:%S", $data[1]);
		$session->comment['author_full'] = split(",", $data[3]);
		$session->comment['author_name'] = $session->comment['author_full'][0];
		$session->comment['author_email'] = $session->comment['author_full'][1];
		$session->comment['title'] = stripslashes($data[4]);
		$session->comment['text'] = $data[5];
		$session->comment['quoted'] = $data[5];
		$session->comment['del'] = $data[6];
		
		$session->plugins->execHook(cHooks::beforeFilterContent, &$session->comment);
	
		$session->plugins->execHook(cHooks::afterFilterContent, &$session->comment);
		
		return true;
	}

}

?>