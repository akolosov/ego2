<?php

class cBlogsContent extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
		$this->_owner->getSession()->board = 1;
		$this->_owner->getConfiguration()->counters_data_path = $this->_owner->getConfiguration()->data_path."/comments/".$this->_owner->getSession()->board."/counters";
	}

	protected function append() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

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
			
			if ($_SERVER['REQUEST_METHOD'] == $config->default_method) {
				
				$session->plugins->execHook(cHooks::beforePostFormProcess, &$session->data);

				$session->storage->setSource($config->blog_data_path);
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
				$session->blog['category'] = $session->data['category'];
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
					$str = explode($config->data_delimiter, $session->id.$config->data_delimiter.$session->blog['category'].$config->data_delimiter.time().$config->data_delimiter.time().$config->data_delimiter.$name.",".$email.$config->data_delimiter.$url_str.$config->data_delimiter.$topic.$config->data_delimiter.$text.$config->data_delimiter.$keys.$config->data_delimiter);
					
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

		if ($_SERVER['REQUEST_METHOD'] == $config->default_method) {
			
			$session->plugins->execHook(cHooks::beforePostFormProcess, &$session->data);

			$session->storage->setSource($config->blog_data_path);
			
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
			$session->blog['category'] = trim(str_replace("\n", "", str_replace("\r", "", $session->data['category'])));
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
				
				$session->blog['category'] = $category;
				
				$str = explode($config->data_delimiter, $session->id.$config->data_delimiter.$session->blog['category'].$config->data_delimiter.$unixtime.$config->data_delimiter.time().$config->data_delimiter.$name.",".$email.$config->data_delimiter.$url_str.$config->data_delimiter.$topic.$config->data_delimiter.$text.$config->data_delimiter.$keys.$config->data_delimiter);
				
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
			$session->storage->setSource($config->blog_data_path);
			
			while ($session->utils->isLockedID($session->module, $session->id)) {
			}
			$session->utils->lockID($session->module, $session->id);
			
			$str = $session->storage->getData($session->id);
			
			if (($session->security->canUser($session->module, $config->right_to_delete) == 1) && ((strpos_x($str[3], trim($session->user['name'])) >= 0) || ($session->user['isadmin']))) {
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
			$session->storage->setSource($config->blog_data_path);
			
			while ($session->utils->isLockedID($session->module, $session->id)) {
			}
			$session->utils->lockID($session->module, $session->id);
			
			$str = $session->storage->getData($session->id);
			
			if (($session->security->canUser($session->module, $config->right_to_delete) == 1) && ((strpos_x($str[3], trim($session->user['name'])) >= 0) || ($session->user['isadmin']))) {
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
		
		$session->storage->setSource($config->blog_data_path);
		
		for ($i=1; $i <= $session->storage->getLastID(); $i++) {
			$data = $session->storage->getData($i);
			if (!empty($data)) {
				$session->blog['id']	= $data[0];
				$session->blog['title']	= $session->formatter->makeKeysStr($data[6]);
				$session->blog['keys']	= $session->formatter->makeKeysStr($data[8]);
				$session->blog['del']	= $data[9];
			
				if (!empty($session->blog['del'])) {
					continue;
				}
				
				$session->postdays[strftime("%m.%Y", $data[2])] .= strftime("%d", $data[2])."|";
			
				if ((strlen($session->blog['title']) >= $config->min_key_length) && ($config->keys_in_titles)) {
					$session->export_text .= $session->blog['id'].$config->data_delimiter.$session->blog['title']."\n";
				}
			
				$keys = split(";", $session->blog['keys']);
				foreach ($keys as $key) {
					$key = trim(chop($key));
					if (strlen($key) >= $config->min_key_length) {
						$session->export_text .= $session->blog['id'].$config->data_delimiter.$key."\n";
					}
				}
				
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
				
				$session->storage->setSource($config->blog_data_path);
				
				if ($config->blog_reverse_sort) {
					$session->storage->Reverse();
				}

				for ($i = 1;$i <= (($config->topics_count_in_export > 0)? $config->topics_count_in_export : $session->storage->getLastID()); $i++) {
				
					if (($i > $config->max_count) || ($i > $session->storage->getLastID())) {
						break;
					}
					
					$data = $session->storage->getData($i);
					
					if ((!is_null($data)) && ($this->filterContent($data))) {
						$session->plugins->execHook(cHooks::beforeExportPost, &$data);
				
						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['text']);
						$session->blog['text'] = $format->Format($session->blog['text'], cFormatLevels::EXPORT, $session->blog['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['text']);
				
						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['title']);
						$session->blog['title'] = $session->formatter->Format($session->blog['title'], cFormatLevels::EXPORT, $session->blog['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['title']);
						
						$session->blog['keys'] = $session->utils->recodeStr($config->default_locale_short, $config->default_export_locale, stripslashes($session->blog['keys']));
						$session->blog['url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=".$session->module."&action=show&id=".$session->blog['id'])), ENT_NOQUOTES);
						$session->blog['comments_url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=comments&action=show&board=1&tid=".$session->blog['id'])), ENT_NOQUOTES);
						$session->blog['author_full_email'] = htmlspecialchars($session->blog['author_name']." <".$session->blog['author_email'].">");
						$session->blog['time'] = gmstrftime("%Y-%m-%dT%H:%M:%SZ", $session->blog['unix_time']);
						$session->blog['update_time'] = gmstrftime("%Y-%m-%dT%H:%M:%SZ", $session->blog['update_unix_time']);
						$session->blog['tag'] = str_replace("http:", "", str_replace("/", "", $session->blog['url'])).",".strftime("%Y-%m-%d", $session->blog['unix_time']).":tst.".$session->blog['unix_time'];
						
						$session->plugins->execHook(cHooks::beforeExportThisPost, &$data);
						$session->export_text .= <<<RSSBODY
<entry>
  <title>{$session->blog['title']}</title>
  <link rel="alternate" type="text/html" href="{$session->blog['url']}" />
  <author>
   <name>{$session->blog['author_name']}</name>
   <email>{$session->blog['author_email']}</email>
  </author>
  <id>tag:{$session->blog['tag']}</id>
  <issued>{$session->blog['time']}</issued>
  <modified>{$session->blog['update_time']}</modified>
  <content type="text/html" mode="escaped">{$session->blog['text']}
RSSBODY;
						$session->plugins->execHook(cHooks::afterExportThisPost, &$data);
						$session->export_text .= "</content>\n</entry>";
						$session->plugins->execHook(cHooks::afterExportPost, &$data);
					}
					$result = true;
				}
				break;
				
			case "rss20" :
				$session->storage->setSource($config->blog_data_path);
				if ($config->blog_reverse_sort) {
					$session->storage->Reverse();
				}
				
				setlocale(LC_TIME, "C");
				
				for ($i = 1;$i <= (($config->topics_count_in_export > 0)? $config->topics_count_in_export : $session->storage->getLastID()); $i++) {
				
					if (($i > $config->max_count) || ($i > $session->storage->getLastID())) {
						break;
					}    
					
					$data = $session->storage->getData($i);
					
					if ((!is_null($data)) && ($this->filterContent($data))) {
						$session->plugins->execHook(cHooks::beforeExportPost, &$data);
				
						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['text']);
						$session->blog['text'] = $format->Format($session->blog['text'], cFormatLevels::EXPORT, $session->blog['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['text']);

						$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['title']);
						$session->blog['title'] = $session->formatter->Format($session->blog['title'], cFormatLevels::EXPORT, $session->blog['id']);
						$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['title']);

						$session->blog['keys'] =  $session->utils->recodeStr($config->default_locale_short, $config->default_export_locale, stripslashes($session->blog['keys']));
						$session->blog['url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=".$session->module."&action=show&id=".$session->blog['id'])), ENT_NOQUOTES);
						$session->blog['comments_url'] = htmlspecialchars(strip_tags($session->utils->makeHRURL($config->site_url."?module=comments&action=show&board=1&tid=".$session->blog['id'])), ENT_NOQUOTES);
						$session->blog['author_full_email'] = htmlspecialchars($session->blog['author_name']." <".$session->blog['author_email'].">");
						$session->blog['time'] = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", $session->blog['unix_time']);
						
						$session->plugins->execHook(cHooks::beforeExportThisPost, &$data);
						$session->export_text .= <<<RSSBODY

<item>
<title>{$session->blog['title']}</title>
<link>{$session->blog['url']}</link>
<comments>{$session->blog['comments_url']}</comments>
<author>{$session->blog['author_full_email']}</author>
<guid isPermaLink="true">{$session->blog['url']}</guid>
<pubDate>{$session->blog['time']}</pubDate>
<description>{$session->blog['text']}
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

		$session->storage->setSource($config->blog_data_path);

		$data = $session->storage->getData($session->tid);
	
		require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/maintance.php");
	
		if ((!is_null($data)) && ($this->filterContent($data))) {
			$session->post_author = $session->blog['author_name']." <".$session->blog['author_email'].">";
			$author_name = $session->blog['author_name'];
			$author_email = $session->blog['author_email'];
			$session->all_title = $session->blog['title'];
			
			$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['text']);
			$session->blog['quoted'] = $session->formatter->Format($session->blog['text'], cFormatLevels::QUOTE, $session->blog['id'], false);
			$session->blog['text'] = $session->formatter->Format($session->blog['text'], cFormatLevels::COMMENT, $session->blog['id']);
			$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['text']);
			
			$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['title']);
			$session->blog['title'] = $session->formatter->Format($session->blog['title'], cFormatLevels::COMMENT, $session->blog['id']);
			$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['title']);

			$session->plugins->execHook(cHooks::beforeShowPost, &$session->blog);

			require($config->styles_modules_path."/".$session->style."/".$session->board_type."/".$session->action."/header.php");
			require($config->styles_modules_path."/".$session->style."/".$session->board_type."/".$session->action."/text.php");
			require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/".$session->board_type."/footer.php");
			
			$session->plugins->execHook(cHooks::afterShowPost, &$session->blog);
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

		$session->storage->setSource($config->blog_data_path);
		if (($config->blog_reverse_sort) && (is_null($session->id)) && (is_null($session->ids))) {
			$session->storage->Reverse();
		}

		if (!is_null($session->id)) {
			$this->showByID($session->id);
		} elseif (!is_null($session->ids)) {
			$ids = split("\|", $session->ids);
			if (!is_null($session->key)) {
				$ids = array_reverse($ids);
			}
			foreach ($ids as $id) {
				if (!empty($id)) { $this->showByID($id); }
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

		$session->storage->setSource($config->blog_data_path);
		if (($config->blog_reverse_sort) && (is_null($session->id)) && (is_null($session->ids))) {
			$session->storage->Reverse();
		}

		if (!is_null($session->id)) {
			$this->showByID($session->id);
		} elseif (!is_null($session->ids)) {
			$ids = split("\|", $session->ids);
			if (!is_null($session->key)) {
				$ids = array_reverse($ids);
			}
			foreach ($ids as $id) {
				if (!empty($id)) { $this->showByID($id); }
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
	
		$session->storage->setSource($config->blog_data_path);
		$data = $session->storage->getData($a_id, $byindex);
		
		if ((!is_null($data)) && ($this->filterContent($data))) {

			$cnt = $session->counters->getData($session->blog['id'], false);
			$comments_count = (!empty($cnt[1]))?$cnt[1]:0;

			if ($session->security->canUser($session->module, $config->right_to_read))  {
			
				if (!empty($session->blog['del'])) {
					$session->blog['title'] = "--".$session->blog['title']."--";
				}
				
				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['text']);
				$session->blog['text'] = $session->formatter->Format($session->blog['text'], cFormatLevels::SHOW, $session->blog['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['text']);
				
				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['title']);
				$session->blog['title'] = $session->formatter->Format($session->blog['title'], cFormatLevels::SHOW, $session->blog['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['title']);

				$session->plugins->execHook(cHooks::beforeShowPost, &$session->blog);

				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/text.php");
				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/footer.php");
				
				$session->plugins->execHook(cHooks::afterShowPost, $session->blog);

				write2log("posts #".$session->blog['id']." showed successfully");
			}
		}
	}

	protected function showTitleByID($a_id = 0, $byindex = true) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		$session->storage->setSource($config->blog_data_path);
		$data = $session->storage->getData($a_id, $byindex);

		if ((!is_null($data)) && ($this->filterContent($data))) {

			$cnt = $session->counters->getData($session->blog['id'], false);
			$comments_count = (!empty($cnt[1]))?$cnt[1]:0;

			if ($session->security->canUser($session->module, $config->right_to_read))  {

				if (!empty($session->blog['del'])) {
					$session->blog['title'] = "--".$session->blog['title']."--";
				}

				$session->plugins->execHook(cHooks::beforeFormatPost, &$session->blog['title']);
				$session->blog['title'] = $session->formatter->Format($session->blog['title'], cFormatLevels::SHOW, $session->blog['id']);
				$session->plugins->execHook(cHooks::afterFormatPost, &$session->blog['title']);

				$session->plugins->execHook(cHooks::beforeShowPost, &$session->blog);

				require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/header.php");

				$session->plugins->execHook(cHooks::afterShowPost, &$session->blog);

				write2log("posts #".$session->blog['id']." showed successfully");
			}
		}
	}

	protected function edit() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		write2log("try to change post #".$session->id);
		
		$session->storage->setSource($config->blog_data_path);
		$data = $session->storage->getData($session->id);
			
		if ((!is_null($data)) && ($this->filterContent($data))) {

			$addons = split(";", $session->blog['addons']);
			$addon1 = split(",", $addons[0]); $session->blog['url_name1'] = $addon1[0]; $session->blog['url1'] = $addon1[1];
			$addon2 = split(",", $addons[1]); $session->blog['url_name2'] = $addon2[0]; $session->blog['url2'] = $addon2[1];

			if ($session->security->canUser($session->module, $config->right_to_change) == 1)  {
				$session->blog['text'] = $session->formatter->Format($session->blog['text'], cFormatLevels::EDIT, $session->blog['id']);
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
			if ((!is_null($session->sub) && ($session->sub <> "all") && ($session->sub <> "archive")) && (($_SERVER['REQUEST_METHOD'] == 'POST')   )) {
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

		$session->blog['id'] = $data[0];
		$session->blog['category'] = $data[1];
		$session->blog['unix_time'] = $data[2];
		$session->blog['date'] = strftime("%d.%m.%Y", $data[2]);
		$session->blog['mounth'] = strftime("%m.%Y", $data[2]);
		$session->blog['time'] = strftime("%H:%M:%S", $data[2]);
		$session->blog['author_full'] = split(",", $data[4]);
		$session->blog['author_name'] = $session->blog['author_full'][0];
		$session->blog['author_email'] = $session->blog['author_full'][1];
		$session->blog['addons'] = $data[5];
		$session->blog['title'] = stripslashes($data[6]);
		$session->blog['text'] = stripslashes($data[7]); 
		$session->blog['keys'] = stripslashes($data[8]);
		$session->blog['del'] = $data[9];
		
		$session->plugins->execHook(cHooks::beforeFilterContent, &$session->blog);
		
 		if ((!is_null($session->id) && in_array($session->sub, $config->subactions_allowed_to_select)) && ($session->blog['id'] <> $session->id)) {
 			return false;
 		}
	
 		if ((!is_null($session->ids) && in_array($session->sub, $config->subactions_allowed_to_select)) && (strpos_x($session->ids, "|".$session->blog['id']."|") === false)) {
 			return false;
 		}
	
		if ((!is_null($session->category)) && ($session->blog['category'] != $session->category)) {
			return false;
		}
	
		if ((!is_null($session->mounth)) && ($session->blog['mounth'] != $session->mounth)) {
			return false;
		}
		
		if ((!is_null($session->date)) && ($session->blog['date'] != $session->date)) {
			return false;
		}

		if ((!in_array($session->blog['category'], $config->categories_allowed_to_view[$session->module])) && !((trim($session->blog['author_name']) == trim($session->user['name'])) || ($session->user['isadmin']))) {
			return false;
		}
	
		if (!is_null($session->search)) {
			if ((!preg_match('/'.$session->search.'/ui', $session->blog['text'])) && (!preg_match('/'.$session->search.'/ui', $session->blog['keys'])) && (!preg_match('/'.$session->search.'/ui', $session->blog['title']))) {
				return false;
			} else {
				$session->blog['text'] = preg_replace('/'.$session->search.'/ui', "**$0**", $session->blog['text']);
			}
		}
	
		if (!is_null($session->key)) {
			if (preg_match('/'.$session->key.'/ui', $session->blog['text'])) {
				$session->blog['text'] = preg_replace('/'.$session->key.'/ui', "**$0**", $session->blog['text']);
			}
		}
			
		if ((!is_null($session->author)) && (!(trim($session->blog['author_name']) == trim($session->author)))) {
			return false;
		}
	
		if (!empty($session->blog['del']) && !(trim($session->blog['author_name']) == trim($session->user['name'])) && (!$session->user['isadmin'])) {
			return false;
		}
		
		$session->plugins->execHook(cHooks::afterFilterContent, &$session->blog);
		
		return true;
	}
}

?>
