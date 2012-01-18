<?php

class cTextFormatter extends cCoreClass {

	private $_wackowiki	= NULL;
	private $_typographica	= NULL;
	
	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
		
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		$this->_typographica = new cTypographicaFormatter($config->use_softhyphen, true, $config->use_wackoformatter);
  		if ($config->use_wackoformatter) {
		     $this->_wackowiki = new WackoFormatter(true);
		     $this->_wackowiki->setObject(new CustomConfig($this->_owner));
		}
	}

	function Format($a_str, $a_level, $a_id = 0, $a_typo = true) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		
		switch ($a_level) {
			case cFormatLevels::SHOW :
				$res = $this->prepareStr($a_str);
				$res = $this->processImages($this->replaceTags($res));
				
				if ($config->use_wackoformatter) {
					$res = $this->_wackowiki->Format($res);
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
					$res = $this->_wackowiki->PostFormat($res);
				} else {
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
				}
				
				$res = $this->cutText($res, $a_id);
				return $res;
				break;
			
			case cFormatLevels::EDIT :
				$res = $this->prepareStr($a_str);
				return $res;
				break;
				
			case cFormatLevels::COMMENT :
				$res = $this->prepareStr($a_str);
				$res = $this->processImages($this->replaceTags($res));
				
				if ($config->use_wackoformatter) {
					$res = $this->_wackowiki->Format($res);
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
					$res = $this->_wackowiki->PostFormat($res);
				} else {
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
				}
				
				$res = $this->cutText($res, $a_id);
				return $res;
				break;
				
			case cFormatLevels::QUOTE :
				$res = str_replace("\n", "<br />", str_replace("<[", "<#<cite>#>", str_replace("]>", "<#</cite>#>", $this->prepareStr($a_str))));
				$res = $this->replaceTags($res);
				$res = htmlspecialchars($res, ENT_QUOTES, $config->default_locale_short);
				$res = $this->stripUnneeded($this->cutText($res, $a_id));
				return $res;
				break;
				
			case cFormatLevels::EXPORT :
				$res = $this->prepareStr($a_str);
				$res = $this->processImages($this->replaceTags($res));
				if ($config->use_wackoformatter) {
					$res = $this->_wackowiki->Format($res);
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
					$res = $this->_wackowiki->PostFormat($res);
				} else {
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
				}
				$res = htmlspecialchars($res, ENT_QUOTES, $config->default_locale_short);
				$res = $this->stripUnneeded($this->cutText($res, $a_id, true));
				$res = $session->utils->recodeStr($config->default_locale_short, $config->default_export_locale, $res);
				
				return $res;
				break;
				
			case cFormatLevels::EMAIL :
				$res = $this->prepareStr($a_str);
				$res = $this->replaceTags($res);
				$res = $this->stripUnneeded($this->cutText($res, $a_id));
				if ($config->use_wackoformatter) {
					$res = $this->_wackowiki->Format($res);
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
					$res = $this->_wackowiki->PostFormat($res);
				} else {
					if ($a_typo) {
						$res = $this->_typographica->Correction($res);
					}
				}
				$res = strip_tags(html_entity_decode($res, ENT_COMPAT, $config->default_locale_short), $config->nonstriped_safe_tags);
				$res = iconv( $config->default_locale_short, $config->default_safe_locale, $session->utils->makeQuotedTextForEMail($res));
				return $res;
				break;
				
			case cFormatLevels::GIZMO :
				$res = $this->prepareStr($a_str);
        			// обработка тэгов [key:...]
        			while (preg_match("/\[key:(?i:(.*?):)?(?i:(".implode("|", $config->ngine_modules)."):)?(.*?)\]/ui", $res, $matches)) {
        				$title = trim($matches[1]);
        				$module = trim($matches[2]);
        				$key = trim($matches[3]);
        				//
        				$title = (empty($title)?$key:$title);
        				$module = (empty($module)?$session->module:$module);
        				//
        				$res = preg_replace("/\[key:(?i:(.*?):)?(?i:(".implode("|", $config->ngine_modules)."):)?(.*?)\]/ui", "[[[siteURL]".$module."/key/".urlencode($key)." ".$title."]]", $res, 1);
        			}
        			// обработка существующих ключей
        			foreach(explode("|", $session->gizmo_keys) as $gizmo_key) {
        				$gizmo_key = trim($gizmo_key);
        				if (!empty($gizmo_key)) {
        					$res = preg_replace("/([\s\n\*\/\_\->])(".$gizmo_key.")([\_\-\*\/\s\n<])/ui", "\\1[[[siteURL]".$session->module."/key/".urlencode($gizmo_key)." \\2]]\\3", $res);
        				}
        			}
        			// обработка ключей в стиле WackoWikiWords
        			if ($config->gizmo_tag_wikiwords) {
        				$res = preg_replace("/([\s\n>])([\/!~])".($config->gizmo_auto_tag_wikiwords?"?":"")."([A-ZА-Я][a-zа-яё\-\/]+[A-ZА-Я0-9][A-Za-zА-Яа-яё0-9\_\-\/]*)/u", "\\1[[[siteURL]".$session->module."/key/\\3 \\3]]", $res);
        			}
				$res = $this->replaceTags($res);
				return $res;
				break;
			default :
				break;
		}
	}

	private function stripUnneeded($str) {
		return preg_replace("/<a name=(.*?)a>/ui", "", preg_replace("/<#(.*?)#>/ui", "", $str));
	}
	
	private function getCutToken($str) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();

		preg_match(cFormatTokens::CUT, $str, $matches);

		if (!is_null($matches)) {
			if (in_array(3, array_keys($matches))) {
				return (empty($matches[5])?$matches[3]:$matches[5]);
			}
		} else {
			return NULL;
		}
	}
	
	function prepareStr($str) {
		
		$res = str_replace("<br />", "\n", stripslashes($str));

		while (preg_match(cFormatTokens::HREF, $res, $matches)) {
			$href    = $matches[1];
			$htitle  = $matches[2];

			$res = preg_replace(cFormatTokens::HREF, "[[".$href." ".$htitle."]]", $res, 1);
		}
		
		return $res;
	}

	function cutText($text, $id, $export = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n    = $this->_owner->getI18N();

		$res = $text;
		$max_length = ((in_array($session->action, $config->exporters_format) || ($export))?$config->max_export_text_length:$config->max_text_length);
		
		$token = $this->getCutToken($text);
		
		if ((strlen(stripslashes(strip_tags($text))) > $max_length) && (is_null($session->id)) && ($max_length > 0) && ($session->module <> "comments") && (is_null($session->search))) {
			$res = substr_x($text, 0, $max_length)."...<br /><strong><a href=\"".$session->utils->makeHRURL("?module=comments&action=show&tid=".$id."&board=".$session->board."#a".$id)."\">[".$i18n->more.(is_null($token)?"":": ".$token)."]</a></strong>";
		} elseif (preg_match(cFormatTokens::CUT, $text) && ($session->module <> "comments") && (is_null($session->search)) && (is_null($session->id)) && (!$export)) {
			$res = substr_x($text, 0, strpos_x($text, cFormatTokens::CUT_TOKEN))."...<br /><strong><a  href=\"".$session->utils->makeHRURL("?module=comments&action=show&tid=".$id."&board=".$session->board."#a".$id)."\">[".$i18n->more.(empty($token)?"":": ").$token."]</a></strong>";
		} 
		
		return preg_replace(cFormatTokens::CUT, "<a name=a".$id."></a>", $this->hideText($res, $export));
	}
	
	function hideText($atext, $export = false) {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n    = $this->_owner->getI18N();

		$res = $atext;

		while (preg_match(cFormatTokens::HIDE, $res, $matches)) {
			$matches[1] = str_replace("\"", "", $matches[1]);
			$htitle  = (empty($matches[1]))?$i18n->hidden:$matches[1];
			$htext   = trim($matches[5]);
			$hpos    = (empty($matches[2]))?"absolute":$matches[2];
			$hwidth  = (empty($matches[3]))?"auto":$matches[3];
			$hheight = (empty($matches[4]))?"auto":$matches[4];
			
			if (($session->module <> "comments") && (is_null($session->search)) && (!$export)) {
				$res = preg_replace(cFormatTokens::HIDE, "<a onClick=\"hideIt('hided_".$htitle."');\" style=\" cursor: pointer; \" title=\"".$i18n->site_actions['show']." ".$htitle."\" class=\"hiddentitle\">[".$htitle."]</a><div id=\"hided_".$htitle."\" class=\"hided\" style=\" display: none; position: ".$hpos."; width: ".$hwidth."; height: ".$hheight."; z-index : 10; \" onDblClick=\"hideIt('".$htitle."');\"><span class=\"topictext\">".$htext."</span></div>", $res, 1);
			} elseif ((!is_null($session->search)) || ($export))  {
				$res = preg_replace(cFormatTokens::HIDE, $htext, $res, 1);
			} else {
				$res = preg_replace(cFormatTokens::HIDE, "", $res, 1);
			}
		}
		
		while (preg_match(cFormatTokens::REM, $res, $matches)) {
			$htext   = $matches[4];
			$hpos    = (empty($matches[1]))?"right":$matches[1];
			$hwidth  = (empty($matches[2]))?"auto":$matches[2];
			$hheight = (empty($matches[3]))?"auto":$matches[3];
			
			if (($session->module <> "comments") && (is_null($session->search)) && (!$export)) {
				$res = preg_replace(cFormatTokens::REM, "<div class=\"remarktext\" style=\" position: static; left: 0; top: 0; float: ".$hpos.";  margin: 5px 10px; margin-".$hpos.": 0px; width: ".$hwidth."; height: ".$hheight."; overflow : visible; \">".$htext."</div>", $res, 1);
			} elseif ((!is_null($session->search)) || ($export))  {
				$res = preg_replace(cFormatTokens::REM, $htext, $res, 1);
			} else {
				$res = preg_replace(cFormatTokens::REM, "", $res, 1);
			}
		}
		
		return $res;
	}

	function replaceTags($str) {
		$config  = $this->_owner->getConfiguration();

		$out = preg_replace("/([\s\n>])\[post:(?i:(.*?):)?(?i:(".implode("|", $config->ngine_modules)."):)?(\d*)(?i:(#.*?))?\]([\s|\n]?)/ui", "\\1[[[siteURL]\\3/show/\\4\\5 \\2]]\\6", $str);
		$out = preg_replace("/\[siteurl\]/i", $config->site_url.(((strpos_x($str, "index.php?") === false) and ($config->use_HRURL))?"index.php?":""), $out);

		return $out;
	}
	
	function processImages($str) {
		$config  = $this->_owner->getConfiguration();
		
		$out = $str;
		
		if (preg_match_all("/([\s\n>])\[image:(?i:(\d+?(?i:\%)):)?(?i:(\d+?):)?(?i:(\d+?):)?(.*?)\]/ui", $out, $matches, PREG_SET_ORDER)) {
			foreach(array_keys($matches) as $Key) {
				$image = $matches[$Key][5]; $h = $matches[$Key][4]; $w = $matches[$Key][3]; $percent = $matches[$Key][2];
				if (!preg_match("/http/ui")) {
					$image = $config->site_url.$image;
				}
				list($width, $height) = getimagesize($image);
				if (($h <= 0) || ($w <= 0)) {
					if ($percent <= 0) {
						$percent = 0.40;
					} else {
						$percent = ($percent / 100);
					}
					$h = (integer) ($height * $percent); $w = (integer) ($width * $percent);
				}
				
				if (preg_match("/je?pg/ui", $image)) {
					$type = "jpeg";
				} elseif (preg_match("/png/ui", $image)) {
					$type = "png";
				} elseif (preg_match("/gif/ui", $image)) {
					$type = "gif";
				}
				
				if (!file_exists($config->cache_data_path."/"."thumb-".basename($image))) {
					$thumb = imagecreatetruecolor($w, $h);
					list($width, $height) = getimagesize($image);
					
					if (preg_match("/je?pg/ui", $image)) {
						$source = imagecreatefromjpeg($image);
					} elseif (preg_match("/png/ui", $image)) {
						$source = imagecreatefrompng($image);
					} elseif (preg_match("/gif/ui", $image)) {
						$source = imagecreatefromgif($image);
					}
					
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $w, $h, $width, $height);
					if (preg_match("/je?pg/ui", $image)) {
						imagejpeg($thumb, $config->cache_data_path."/"."thumb-".basename($image));
					} elseif (preg_match("/png/ui", $image)) {
						imagepng($thumb, $config->cache_data_path."/"."thumb-".basename($image));
					} elseif (preg_match("/gif/ui", $image)) {
						imagegif($thumb, $config->cache_data_path."/"."thumb-".basename($image));
					}
					imagedestroy($thumb);
					imagedestroy($source);
				}
				
				$repl_str = "<#<div class=\"image\"><a href=\"".$image."\" target=\"_blank\"><image src=\"".$config->site_url.$config->cache_data_path."/thumb-".basename($image)."\" title=\"изображение ".basename($image)."/".$width."x".$height."\" width=\"".$w."\" height=\"".$h."\" class=\"imageself\" /></a></div>#>";
				$out = preg_replace("/([\s\n>])\[image:(.*?)\]/ui", $repl_str, $out, 1);
				
			}
		}
		return $out;
	}

	function replacePermanentlyTags($str) {
		$i18n    = $this->_owner->getI18N();

		$out = preg_replace("/\[date\]/i", strftime("%d.%m.%Y"), $str);
		$out = preg_replace("/\[time\]/i", strftime("%H:%M"), $out);
		$out = preg_replace("/\[datetime\]/i", strftime("%d.%m.%Y")." ".$i18n->at." ".strftime("%H:%M"), $out);

		return $out;
	}

	function makeKeysStr($str) {
		$out = preg_replace("/^[0-9\-\.\ ]{1,}[\w]+$/", "", $str);
		$out = preg_replace("/[\ \.\!]{2,}/", " ", $out);
		$out = preg_replace("/([\-|\.]?)([0-9]{1,})$/", "", $out);

		$out = stripslashes(strip_tags($out));
		$out = str_replace(".", " ", $out);
		$out = str_replace(",", " ", $out);
		$out = str_replace("!", " ", $out);
		$out = str_replace("+", " ", $out);
		$out = str_replace("?", " ", $out);
		$out = str_replace("\"", "", $out);
		$out = str_replace("'", "", $out);
		$out = str_replace(":", " ", $out);
		$out = str_replace("`", " ", $out);
		$out = str_replace("(", " ", $out);
		$out = str_replace(")", " ", $out);
		$out = str_replace("|", " ", $out);
		$out = str_replace(" -", " ", $out);
		$out = str_replace("- ", " ", $out);
		$out = chop($out);
		return $out;
	}

}

class CustomConfig extends WackoFormatterConfigDefault  {
//
	public	$config = array("allow_rawhtml"  => 1,
			"disable_npjlinks"   => 1,
			"disable_tikilinks"  => 1,
			"disable_wikilinks"  => 1,
			"disable_formatters" => 0,
			"html"               => 1);
			
	private $_owner = NULL;
//
	function __construct($a_owner) {
		$this->_owner = $a_owner;
	}
//
	function Format($text, $formatter = "", $params = array()) {
	
		$engine = $this->_owner;

		$fullfilename = $engine->getConfiguration()->classes_path."/formatters/".$formatter.".php";
		
		if (@file_exists($fullfilename)) {
			if (is_array($params)) {
			    extract($params, EXTR_SKIP);
			}
			ob_start();
			include($fullfilename);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
		return $text;
	}

	function PreLink($url, $text=false) {

		$engine = $this->_owner;

		if (!$text) {
			$text = htmlspecialchars($url);
		}

		return "<a href=\"".$url."\" ".((strpos_x($url, $engine->getConfiguration()->site_url)===false)?"target=\"_blank\"":"")." title=\"[".((strpos_x($url, $engine->getConfiguration()->site_url)===false)?$engine->getI18N()->site_modules['external']:$engine->getI18N()->site_modules['local'])." : ".strip_tags($text)." (".$url.")]\" ".($engine->getConfiguration()->use_google_nofollow?"rel=\"nofollow\"":"").">".$text."</a>";
	 }

	function Link ($url, $options, $text) { 

		$engine = $this->_owner;

		if (!$text) {
			$text = htmlspecialchars($url);
		}

		return "<a href=\"".$url."\" ".((strpos_x($url, $engine->getConfiguration()->site_url)===false)?"target=\"_blank\"":"")." title=\"[".((strpos_x($url, $engine->getConfiguration()->site_url)===false)?$engine->getI18N()->site_modules['external']:$engine->getI18N()->site_modules['local'])." : ".strip_tags($text)." (".$url.")]\" ".($engine->getConfiguration()->use_google_nofollow?"rel=\"nofollow\"":"").">".$text."</a>";
	}
}

?>
