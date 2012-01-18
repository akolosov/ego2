<?php

class cCoreUtils extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}

	function getCalendarDays() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$session->storage->setSource($config->calendars_data_path."/".$session->module);
		foreach (($session->storage->getBuffer()) as $date_m) {
			$date = split($config->data_delimiter, $date_m);
			if (trim($date[0]) == trim($session->month.".".$session->year)) {
				$days = split("\|", $date[1]);
					foreach ($days as $day) {
					if (!is_null($day)) {
						$day_data = split("/", $day); $day = $day_data[0]; $count = $day_data[1];
						$session->days[(integer)$day] = array($this->makeHRURL("?module=".$session->module."&action=show&date=".$day.".".$session->month.".".$session->year."&sub=all"), NULL, NULL, $count);
					}
				}
			}
		}
	
	}

	function makeHRURL($str) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		if ($config->use_HRURL) {
			$out = str_replace("&", "/", $str);
			$out = str_replace("#", "/#", $out);
			$out = str_replace("?", "", $out);
			$out = str_replace("module=", "", $out);
			$out = str_replace("action=", "", $out);
			$out = str_replace("sub=", "", $out);
			$out = str_replace("tid=", "t", $out);
			$out = str_replace("pid=", "p", $out);
			$out = str_replace("id=", "i", $out);
			$out = str_replace("ids=", "s", $out);
			$out = str_replace("board=", "b", $out);
			$out = str_replace("first=", "f", $out);
			$out = str_replace("count=", "c", $out);
			$out = str_replace("key=", "key/", $out);
			$out = str_replace("theme=", "theme/", $out);
			$out = str_replace("style=", "style/", $out);
			$out = str_replace("search=", "search/", $out);
			$out = str_replace("date=", "date/", $out);
			$out = str_replace("mounth=", "mounth/", $out);
			$out = str_replace("category=", "category/", $out);
			$out = str_replace("language=", "language/", $out);
			return $out;
		} else {
			return $str;
		}
	}

	function getKeyIDs($module, $akey) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$session->storage->setSource($config->keys_data_path."/".$module);
		$found = $session->storage->getIDbyData($config->data_delimiter.$akey.$config->data_delimiter);
		if ($found > 0) {
			$key_data = $session->storage->getData($found);
			return "|".$key_data[2];
		} else {
			return "";
		}
	}

	function parseOPML($write = false) {
	
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
	
		$res = $matches = $mmatches = array();
		$group = "n00p";
		
		if ((file_exists($config->opml_data_path)) && (filemtime($config->opml_data_path) > filemtime($config->bookmarks_data_path."/public"))) {
		
			$lines = File($config->opml_data_path);
			foreach ($lines as $line) {
			
				if (preg_match("/<outline(.*?)[^\/]>/sui", trim($line), $matches)) {
				
					if (preg_match("/text=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$group = $mmatches[1];
					}
					
					if (preg_match("/title=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$group = $mmatches[1];
					}
					
				} elseif (preg_match("/<outline(.*?)\/>/sui", trim($line), $matches)) {
					if (preg_match("/useNotification=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$notify = "friends";
					} else {
						if (trim($group) == "friends") {
							$notify = $group;
						} else {
							$notify = "public";
						}
					}
				
					if (preg_match("/htmlUrl=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$htmlUrl = $mmatches[1];
						if (empty($htmlUrl) || is_null($htmlUrl)) {
							if (preg_match("/xmlUrl=\"(.*?)\"/ui", $matches[1], $mmatches)) {
								$xmlUrl = parse_url($mmatches[1]);
								$htmlUrl = $xmlUrl['scheme']."://".$xmlUrl['host']."/";
							}
						}
						$res[$notify][$group][$htmlUrl]['htmlUrl'] = $htmlUrl;
					}
					
					if (preg_match("/xmlUrl=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$res[$notify][$group][$htmlUrl]['xmlUrl'] = $mmatches[1];
					}
					
					if (preg_match("/title=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$res[$notify][$group][$htmlUrl]['title'] = $mmatches[1];
					}
					
					if (preg_match("/text=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$res[$notify][$group][$htmlUrl]['text'] = $mmatches[1];
					}
					
					if (preg_match("/description=\"(.*?)\"/ui", $matches[1], $mmatches)) {
						$res[$notify][$group][$htmlUrl]['description'] = $mmatches[1];
					}
					
					$res[$notify][$group][$htmlUrl]['group'] = $group;
				}
			}

			if ($write) {
				foreach (array_keys($res) as $Key) {
					$id	= 1;
					$str	= "";
					foreach (array_keys($res[$Key]) as $Group) {
						foreach (array_keys($res[$Key][$Group]) as $Data) {
							$str .= ($id++).$config->data_delimiter.$res[$Key][$Group][$Data]['title'].$config->data_delimiter."external".$config->data_delimiter.$res[$Key][$Group][$Data]['htmlUrl'].$config->data_delimiter.$config->data_delimiter."pub".$config->data_delimiter.$res[$Key][$Group][$Data]['xmlUrl'].$config->data_delimiter.$res[$Key][$Group][$Data]['group'].$config->data_delimiter."\n";
						}
					}
					
					$session->storage->setSource($config->bookmarks_data_path."/".$Key);
					$session->storage->setBuffer(explode("\n", trim(chop($str))), true);
				}
			} else {
				return $res;
			}
		}
	}

	function getKeysList($modules, $for_select = false, $for_click = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
	
		$modules = explode(" ", $modules);
		$out = "";
		
		foreach ($modules as $module) {
			$session->storage->setSource($config->keys_data_path."/".$module);
			foreach ($session->storage->getBuffer() as $key) {
				$key_data = split($config->data_delimiter, $key);
				$key_data[1] = trim(chop($key_data[1]));
				if (!empty($key_data[1])) {
					if ($for_select) {
						$out .= "<option value=\"".($for_click?$module.":".$key_data[1]:$key_data[1])."\" />&nbsp;&raquo;&nbsp;".$key_data[1]."\n";
					} else {
						$out .= $key_data[1]."\n";
					}
				}
			}
		}
		
		return $out;
	}
	
	function hideEMail($str) {
		$config  = $this->_owner->getConfiguration();
		
		if ($config->hide_email) {
			return str_replace("@", " ".$config->at_replace." ", str_replace(".", " dot ", $str));
		} else {
			return $str;
		}
	}

	function setCounter($xml = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		$message="";
		$ip = getenv("REMOTE_ADDR").$config->data_delimiter.getenv("HTTP_X_FORWARDED_FOR"); 
		$referer = trim(getenv("HTTP_REFERER"));
		$datum = strftime("%d.%m.%Y"); 
		
		$fp = fopen($config->hits_count_data_path, "rb"); 
		flock($fp, LOCK_SH); 
		$conts = fread ($fp, filesize ($config->hits_count_data_path)); 
		fclose($fp); 
		
		$content = explode("\n", $conts); 
		$counts = explode($config->data_delimiter, $content[0]); 
		
		if (strpos_x(implode("\n", $content), $ip) === false) {
			$content[] = $ip.$config->data_delimiter.$referer;
			$counts[1]++; // unique today
			$counts[4]++; // unique total
		} else {
			if (!empty($referer)) {
				for ($i = 0; $i <= count($content); $i++) {
					if (!(strpos_x($content[$i], $ip) === false)) {
						$ip_data = split($config->data_delimiter, $content[$i]);
						$refs = split("##", $ip_data[2]);
						if ((!in_array($referer, $refs)) && (strpos_x($referer, $config->site_url) === false)) {
							$ip_data[2] .= "##".$referer;
						}
						$content[$i] = implode($config->data_delimiter, $ip_data);
						break;
					}
				}
			}
		}
		
		$counts[2]++; // total today
		$counts[3]++; // total
		if ($xml) {
			$counts[6]++; // total xml
			$counts[5]++; // today xml
		}
		
		if ($counts[0] != $datum) { 
			if ($config->use_history) {
				$fp = fopen($config->history_data_path."/".$counts[0], "wb+"); 
				if ($fp) {
					fwrite($fp, implode("\n", $content));
					fclose($fp); 
				}
			}
			$message = "fucking time";
			$counts[0] = $datum; $counts[1] = 1; $counts[2] = 1; $counts[4]++; $counts[5] = ($xml)?1:0; $counts[6] += ($xml)?1:0;
		} 
		
		$res = sprintf("<span class=\"hits\">[ Total: <b>%s/%s</b> ][ Today: <b>%s/%s</b> ][ XML: <b>%s/%s</b> ][ Time: <b>%s sec</b> ]</span>", $counts[3], $counts[4], $counts[2], $counts[1], $counts[6], $counts[5], getProcessTime($session->time_start));
		
		$content[0] = $counts[0].$config->data_delimiter.$counts[1].$config->data_delimiter.$counts[2].$config->data_delimiter.$counts[3].$config->data_delimiter.$counts[4].$config->data_delimiter.$counts[5].$config->data_delimiter.$counts[6]; 
		$fd = fopen($config->hits_count_data_path, "a"); 
		$locked = flock($fd, 2); 
		
		if ($locked) { 
			$fp = fopen($config->hits_count_data_path, "wb+"); 
			if ($message) {
				fwrite($fp, $content[0]."\n".$ip.$config->data_delimiter.$referer);
			} else {
				fwrite($fp, implode("\n", $content));
			}
			fclose($fp); 
		} 
		
		fclose($fd); 
		
		return $res;
	}

	function getCategoriesList($selected = "", $for_select = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$out = "";
		
		$session->storage->setSource($config->categories_data_path);
		
		foreach ($session->storage->getBuffer() as $category) {
			$category_data = split($config->data_delimiter, $category);
			$category_data[0] = trim(chop($category_data[0]));
			$category_data[1] = trim(chop($category_data[1]));
			$category_data[2] = trim(chop($category_data[2]));
			if ($category_data[2] == $session->module) {
				if ($for_select) {
					$out .= "<option value=\"".$category_data[0]."\" ".(($category_data[0] === $selected)?"selected":"")." />".$category_data[1]."\n";
				} else {
					$out .= $category_data[1]."\n";
				}
			}
		}
		
		return $out;
	}
	
	function getPostsList($for_select = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$out = "";
		
		if (is_null($session->board_type)) {
			$session->storage->setSource($config->data_path."/".$session->module);
		} else {
			$session->storage->setSource($config->data_path."/".$session->board_type);
		}
		$session->storage->Reverse();
		
		foreach ($session->storage->getBuffer() as $post) {
			$post_data = split($config->data_delimiter, $post);
			$post_data[0] = trim(chop($post_data[0]));
			$post_data[6] = trim(chop($post_data[6]));
			if ($for_select) {
			$out .= "<option value=\"".$session->module.":".$post_data[0]."\" />".$post_data[6]."\n";
			} else {
			$out .= $post_data[6]."\n";
			}
		}
		
		return $out;
	}

	function lockID($module, $aid) {
		$config  = $this->_owner->getConfiguration();
		
		if (!file_exists($config->locks_data_path."/".$module.".".$aid)) {
			touch($config->locks_data_path."/".$module.".".$aid);
		}
	}
	
	function unlockID($module, $aid) {
		$config  = $this->_owner->getConfiguration();
		
		if (file_exists($config->locks_data_path."/".$module.".".$aid)) {
			unlink($config->locks_data_path."/".$module.".".$aid);
		}
	}
	
	function isLockedID($module, $aid) {
		$config  = $this->_owner->getConfiguration();
	
		return file_exists($config->locks_data_path."/".$module.".".$aid);
	}
	
	function recodeStr($from, $to, $str) {
		if (trim($from) <> trim($to)) {
			return iconv($from, $to, $str);
		} else {
			return $str;
		}
	}

	function encodeEMail($in_str, $charset) {
		$out_str = $in_str;
		
		if ($out_str && $charset) {
			
			// define start delimimter, end delimiter and spacer
			$end = "?=";
			$start = "=?" . $charset . "?B?";
			$spacer = $end . "\r\n " . $start;
			
			// determine length of encoded text within chunks
			// and ensure length is even
			$length = 75 - strlen($start) - strlen($end);
			$length = floor($length/2) * 2;
			
			// encode the string and split it into chunks
			// with spacers after each chunk
			$out_str = base64_encode($out_str);
			$out_str = chunk_split($out_str, $length, $spacer);
			
			// remove trailing spacer and
			// add start and end delimiters
			$spacer = preg_quote($spacer);
			$out_str = preg_replace("/" . $spacer . "$/", "", $out_str);
			$out_str = $start . $out_str . $end;
		}
		return $out_str;
	}

	function isUTF8($str) {
		return preg_match("/([\x09\x0A\x0D\x20-\x7E]|[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})*/x", $str);
	}

	function makeQuotedTextForEMail($atext, $char = "") {
	
		$text = str_replace("<br />", "!!br!!", html_entity_decode($atext, ENT_QUOTES));
	
		if (preg_match_all("/<cite>(.*?)<\/cite>/sui", $text, $matches, PREG_PATTERN_ORDER)) {
			for ($i = 0; $i <= count($matches); $i++) {
				$matches[1][$i] = str_replace("!!br!!", "!!br!!>", $matches[1][$i]);
				$text = str_replace($matches[0][$i], "!!br!!!!br!!>".wordwrap($matches[1][$i], 150, "!!br!!>")."!!br!!", $text);
			}
		}
	
		if (preg_match_all("/<blockquote>(.*?)<\/blockquote>/sui", $text, $matches, PREG_PATTERN_ORDER)) {
			for ($i = 0; $i <= count($matches); $i++) {
				$matches[1][$i] = str_replace("!!br!!", "!!br!!>", $matches[1][$i]);
				$text = str_replace($matches[0][$i], "!!br!!>".wordwrap($matches[1][$i], 150, "!!br!!>"), $text);
			}
		}
	
		return preg_replace("/!!br!!/sui", "\n", $text);
	}
	
	function getNotifyList($aboard, $atid) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		$session->storage->setSource($config->notify_data_path);
		$found = $session->storage->getIDbyData("^".$aboard.$config->data_delimiter.$atid.$config->data_delimiter);
		
		if ($found > 0) {
			$nnn = $session->storage->getData($found);
			return  $nnn[2];
		} else {
			return "";
		}
	}

	function addToNotifyList($aboard, $atid, $addr) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		$res = array();
		
		$session->storage->setSource($config->notify_data_path);
		$found = $session->storage->getIDbyData("^".$aboard.$config->data_delimiter.$atid.$config->data_delimiter);
		if ($found > 0) {
			if (!preg_match("/.*".$addr.".*/sui", implode($config->data_delimiter, $session->storage->getData($found)))) {
				$res = $session->storage->getData($found);
				$res[2] .= ", ".$addr;
				$session->storage->Update($found, $res);
			}
		} else {
			$res[] = $aboard;
			$res[] = $atid;
			$res[] = $addr;
			$session->storage->Append($res);
		}
	}


	function printKeysPage($modules) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
			
		$modules = explode(" ", trim($modules));
		
		foreach ($modules as $module) {
		
			$session->storage->setSource($config->keys_data_path."/".$module);
			$keys = $session->storage->getBuffer();
	
			if (!empty($keys)) {
				if (file_exists($config->styles_modules_path."/".$session->style."/keys/header.php")) {
					require($config->styles_modules_path."/".$session->style."/keys/header.php");
				}	
	
				$i = 0;
				$pred = (count($keys)/2);
				foreach ($keys as $key) {
			
					if ($i >= $pred) {
						$i = 0;
						if (file_exists($config->styles_modules_path."/".$session->style."/keys/delimiter.php")) {
							require($config->styles_modules_path."/".$session->style."/keys/delimiter.php");
						}	
					}
				
					if (!empty($key)) {
						$key_data = split($config->data_delimiter, $key);
						$keys_id = split("\|", $key_data[2]);
						if (!empty($key_data[2]) && !empty($key_data[1])) {
							if (file_exists($config->styles_modules_path."/".$session->style."/keys/text.php")) {
								require($config->styles_modules_path."/".$session->style."/keys/text.php");
							}
						}
						$i++;
					}
				}
				if (file_exists($config->styles_modules_path."/".$session->style."/keys/footer.php")) {
					require($config->styles_modules_path."/".$session->style."/keys/footer.php");
				}
			}
		}
	}
	
	function printBookmarksPage($users) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		$users = explode(" ", trim($users));
		
		foreach ($users as $user) {
			$session->storage->setSource($config->bookmarks_data_path."/".trim($user));
			$bookmarks = $session->storage->getBuffer();
		
			if ((!empty($bookmarks)) && ($config->use_bookmarks) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))) {
				
				if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/header.php")) {
					require($config->styles_modules_path."/".$session->style."/bookmarks/header.php");
				}	
				
				if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/sub_header.php")) {
					require($config->styles_modules_path."/".$session->style."/bookmarks/sub_header.php");
				}	
				
				$i = 0;
				$pred = (count($bookmarks)/2);
				foreach ($bookmarks as $bookmark) {
				
					if ($i >= $pred) {
					$i = 0;
						if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/delimiter.php")) {
							require($config->styles_modules_path."/".$session->style."/bookmarks/delimiter.php");
						}
					}
			
					if (!empty($bookmark)) {
					$bookmark = str_replace("\n", "", str_replace("\r", "", $bookmark));
					$bookmark_data = split($config->data_delimiter, $bookmark);
					
					if (!empty($bookmark_data[3]) && !empty($bookmark_data[2]) && !empty($bookmark_data[1]) && !empty($bookmark_data[0])) {
						$bookmark_data[5] = trim($bookmark_data[5]);
						$bookmark_feed = trim($bookmark_data[6]);
						if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/text.php")) {
							require($config->styles_modules_path."/".$session->style."/bookmarks/text.php");
						}
					}
					$i++;
					}
				}
				if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/sub_footer.php")) {
					require($config->styles_modules_path."/".$session->style."/bookmarks/sub_footer.php");
				}	
				if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/footer.php")) {
					require($config->styles_modules_path."/".$session->style."/bookmarks/footer.php");
				}	
			}
		}
	}
	
	function printCommentsPage() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
			
		$session->storage->setSource($config->counters_data_path);
		$session->storage->Sort("CompareComments");
		$comments = $session->storage->getBuffer();
		
		if (!empty($comments)) {
			$i = 0;
			$pred = (count($comments)/2);
			foreach ($comments as $comment) {
					
				if ($i >= $pred) {
					$i = 0;
					if (file_exists($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/delimiter.php")) {
						require($config->styles_modules_path."/".$session->style."/".$session->module."/".$session->action."/delimiter.php");
					}
				}
					
				if (!empty($comment)) {
					$comment_data = split($config->data_delimiter, $comment);
				
					if (!empty($comment_data[0]) && !empty($comment_data[2])) {
						print "<span class=\"topic\"><nobr>";
						print "<a href=\"".$session->utils->makeHRURL("?module=comments&action=show&board=".$session->board."&tid=".$comment_data[0])."\" class=\"topic\">".stripslashes($comment_data[2])."</a> (".$comment_data[1].") <span class=\"hits\">// ".strftime("%d.%m.%Y", $comment_data[3])."</span>";
						print "</nobr></span><br />\n";
					}
					$i++;
				}
			}
		}
	}

	function printBookmarksList($users) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		$users = explode(" ", trim($users));
		
		foreach ($users as $user) {
			$session->storage->setSource($config->bookmarks_data_path."/".trim($user));
			$bookmarks = $session->storage->getBuffer();

			if ((!empty($bookmarks)) && ($config->use_bookmarks) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))) {
				if ((file_exists($config->styles_modules_path."/".$session->style."/bookmarks/list/header.php")) && ((!(strpos_x(implode("\n", $bookmarks), $config->data_delimiter.$session->module.$config->data_delimiter) === false)) || (!(strpos_x(implode("\n", $bookmarks), $config->data_delimiter.$config->external_link_name.$config->data_delimiter) === false)))) {
					require($config->styles_modules_path."/".$session->style."/bookmarks/list/header.php");
				}
			
				$i = 0;
				foreach ($bookmarks as $bookmark) {
					if (!empty($bookmark)) {
						$bookmark_data = split($config->data_delimiter, $bookmark);
						if (!empty($bookmark_data[3]) && !empty($bookmark_data[2]) && !empty($bookmark_data[1]) && !empty($bookmark_data[0])) {
							if (strlen($bookmark_data[1]) > $config->max_bookmark_length) {
								$bookmark_title = substr_x($bookmark_data[1], 0, $config->max_bookmark_length)."...";
							} else {
								$bookmark_title = $bookmark_data[1];
							}
						
							$bookmark_feed  = trim($bookmark_data[6]);
							$bookmark_group = trim($bookmark_data[7]);
							$bookmark_desc  = trim($bookmark_data[1]);
					
							$bookmark_data[4] = trim($bookmark_data[4]);
							$bookmark_data[2] = trim($bookmark_data[2]);
							if ((($session->module == $bookmark_data[2]) || ($bookmark_data[2] == $config->external_link_name) || ($bookmark_data[2] == $config->public_user_name) || (($config->import_from_opml) && (!empty($bookmark_data[2])) )) && (empty($bookmark_data[4]))) {
								if (file_exists($config->styles_modules_path."/".$session->style."/bookmarks/list/text.php")) {
									require($config->styles_modules_path."/".$session->style."/bookmarks/list/text.php");
								}
							}
							$i++;
							if ($i >= $config->bookmarks_count_on_addons) {
								break;
							}
						}
					}
				}
				if ((file_exists($config->styles_modules_path."/".$session->style."/bookmarks/list/footer.php"))) {
					require($config->styles_modules_path."/".$session->style."/bookmarks/list/footer.php");
				}
			}
		}
	}
	
	function printKeysList() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		$session->storage->setSource($config->keys_data_path."/".$session->module);
		$keys = $session->storage->getBuffer();
		
		if ((!empty($keys)) && ($config->use_keywords) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))) {
			if (file_exists($config->styles_modules_path."/".$session->style."/keys/list/header.php")) {
				require($config->styles_modules_path."/".$session->style."/keys/list/header.php");
			}
				
			$i = 0;
			foreach ($keys as $key) {
				if (!empty($key)) {
					$key_data = split($config->data_delimiter, $key);
					$keys_id = split("\|", $key_data[2]);
					if (!empty($key_data[2]) && !empty($key_data[1])) {
						
						$i++;
						if ($i > $config->keys_count_on_addons) {
							break;
						}
					
						if (($config->max_key_length > 0) && (strlen($key_data[1]) > $config->max_key_length)) {
							$key_title = substr_x($key_data[1], 0, $config->max_key_length)."...";
						} else {
							$key_title = $key_data[1];
						}
						if (file_exists($config->styles_modules_path."/".$session->style."/keys/list/text.php")) {
							require($config->styles_modules_path."/".$session->style."/keys/list/text.php");
						}
					}
				}
			}
			if (file_exists($config->styles_modules_path."/".$session->style."/keys/list/footer.php")) {
				require($config->styles_modules_path."/".$session->style."/keys/list/footer.php");
			}
		}
	}
	
	function printCommentsList() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		$session->storage->setSource($config->counters_data_path);
		$session->storage->Sort("CompareComments");
		$comments = $session->storage->getBuffer();
		
		if ((!empty($comments)) && ($config->use_comments) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))) {
			if (file_exists($config->styles_modules_path."/".$session->style."/comments/list/header.php")) {
				require($config->styles_modules_path."/".$session->style."/comments/list/header.php");
			}
				
			$i = 0;
			foreach ($comments as $comment) {
				if (!empty($comment)) {
					$comment_data = split($config->data_delimiter, $comment);
					if (!empty($comment_data[2]) && !empty($comment_data[1])) {
					
						$i++;
						if ($i > $config->comments_count_on_addons) {
							break;
						}
					
						if (strlen($comment_data[2]) > $config->max_comment_length) {
							$comment_title = substr_x(stripslashes($comment_data[2]), 0, $config->max_comment_length)."...";
						} else {
							$comment_title = stripslashes($comment_data[2]);
						}
						
						if (file_exists($config->styles_modules_path."/".$session->style."/comments/list/text.php")) {
							require($config->styles_modules_path."/".$session->style."/comments/list/text.php");
						}
					
					}
				}
			}
			
			if (file_exists($config->styles_modules_path."/".$session->style."/comments/list/footer.php")) {
				require($config->styles_modules_path."/".$session->style."/comments/list/footer.php");
			}
		}
	}

	function getThemesList($for_select = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		$out = "";
		$session->storage->setSource($config->themes_data_path);
		foreach ($session->storage->getBuffer() as $theme) {
			$theme_data = split($config->data_delimiter, $theme);
			$theme_data[0] = trim(chop($theme_data[0]));
			$theme_data[1] = trim(chop($theme_data[1]));
			if (!empty($theme_data[0])) {
				if ($for_select) {
					$out .= "<option value=\"".$this->makeHRURL($theme_data[0])."\" />".$theme_data[1]."\n";
				} else {
					$out .= $theme_data[1]."\n";
				}
			}
		}
		
		return $out;
	}
	
	function getStylesList($for_select = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		$out = "";
		$session->storage->setSource($config->styles_data_path);
		foreach ($session->storage->getBuffer() as $style) {
			$style_data = split($config->data_delimiter, $style);
			$style_data[0] = trim(chop($style_data[0]));
			$style_data[1] = trim(chop($style_data[1]));
			if (!empty($style_data[0])) {
				if ($for_select) {
					$out .= "<option value=\"".$this->makeHRURL($style_data[0])."\" />".$style_data[1]."\n";
				} else {
					$out .= $style_data[1]."\n";
				}
			}
		}
		
		return $out;
	}
	
	function getModuleMenu() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$format  = $this->_owner->getFormatter();
		
		$session->storage->setSource($config->menus_data_path);
		$found = $session->storage->getIDbyData("^".$session->module.$config->data_delimiter);
		if ($found > 0) {
			$menu_data = $session->storage->getData($found);
			$menu_items = split("\|\|", $menu_data[1]);
			foreach ($menu_items as $menu_item) {
				$out .= "<p class=\"topicmenu\">".$session->formatter->Format($menu_item, cFormatLevels::SHOW, 0)."</p>";
			}
		}
		
		return $out;
	
	}

}

?>