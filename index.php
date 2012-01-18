<?php
//
// $Id: index.php,v 1.1 2005/05/11 07:36:41 hunter Exp $
//
class cCoreConfig {
	const LOGS_DIR		= "data/logs";
	const DEBUG_MODE	= false;
	const FULL_DEBUG_MODE	= false;
	const MODULES_PATH	= "engine/modules";
	const CLASSES_PATH	= "engine/classes";
	const TEMPLATES_PATH	= "engine/templates";
	const DELIMITER		= "@@";
	const TIMEZONE		= "Asia/Yekaterinburg";
}
//
date_default_timezone_set(cCoreConfig::TIMEZONE);
//
require_once(cCoreConfig::MODULES_PATH."/common.php");
//
$engine = new cMyselfEngineCore(NULL, cCoreConfig::DEBUG_MODE, "./config.php");
//
require_once($engine->getConfiguration()->themes_modules_path."/".$engine->getSession()->theme.".php");
//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?= $engine->getConfiguration()->default_locale_short; ?>" />
  <meta http-equiv="Content-Language" content="ru" />
  <meta name="Keywords" content="alexey kolosov blog, huNTer's blog, blog engine, PHP, CMS, Perl, OpenSource, Linux, BSD, GNU, BLog, eGo, <?= str_replace("\n", ", ", $engine->getUtils()->getKeysList(implode(" ", $engine->getConfiguration()->ngine_modules), false)); ?>" />
  <meta name="Description" content="<?= $engine->getConfiguration()->site_name; ?>" />
  <title><?= $engine->getConfiguration()->site_name." - ".$engine->getI18N()->site_modules[$engine->getSession()->module]."/".$engine->getI18N()->site_actions[$engine->getSession()->action]."/".($engine->getSession()->search?$engine->getI18N()->site_actions["search"].":".$engine->getSession()->search."/":"").($engine->getSession()->date?$engine->getSession()->date."/":"").($engine->getSession()->mounth?$engine->getSession()->mounth."/":"").($engine->getSession()->key?$engine->getI18N()->site_actions["keys"].":".$engine->getSession()->key."/":"").($engine->getSession()->sub?$engine->getI18N()->site_actions[$engine->getSession()->sub]:""); ?></title> 
  <base href="<?= $engine->getConfiguration()->site_url; ?>" />
  <link rel="icon" href="/images/favicon.png" type="image/x-png" />
  <link rel="shortcut icon" href="/images/favicon.png" type="image/x-png" />
  <link rel="stylesheet" href="/css/common.css" type="text/css" />
  <link rel="stylesheet" href="/css/themes/<?= $engine->getSession()->theme; ?>.css" type="text/css" />
  <link rel="stylesheet" href="/css/styles/<?= $engine->getSession()->style; ?>/override.css" type="text/css" />
<? if (in_array($engine->getSession()->module, $engine->getConfiguration()->export_in_modules)): ?>
  <? if ($engine->getConfiguration()->export_to_rss): ?>
  <link rel="alternate" type="application/rss+xml" title="<?= $engine->getConfiguration()->site_short_name." | ".$engine->getI18N()->site_modules[$engine->getSession()->module]." | RSS 2.0"; ?>" href="<?= $engine->getUtils()->makeHRURL($engine->getConfiguration()->site_url."?module=".$engine->getSession()->module."&action=rss20"); ?>" />
  <? endif; ?> 
  <? if ($engine->getConfiguration()->export_to_atom): ?>
  <link rel="alternate" type="application/atom+xml" title="<?= $engine->getConfiguration()->site_short_name." | ".$engine->getI18N()->site_modules[$engine->getSession()->module]." | ATOM 0.3"; ?>" href="<?= $engine->getUtils()->makeHRURL($engine->getConfiguration()->site_url."?module=".$engine->getSession()->module."&action=atom03"); ?>" />
  <? endif; ?> 
<? endif; ?> 
  <script language="JavaScript">
<!--
	var Client = navigator.userAgent.toLowerCase();
	var isDOM  = document.getElementById; //DOM1 browser
	var isMZ   = isDOM && (navigator.appName == "Netscape") && (Client.indexOf('opera') == -1);
	var isO    = window.opera && isDOM && (Client.indexOf('opera') != -1); //Opera 5+
	var isO6   = isO && window.print; //Opera 6+
	var isO7   = isO && document.readyState; //Opera 7+
	var isO8   = isO && document.createProcessingInstruction && (new XMLHttpRequest()).getAllResponseHeaders //Opera 8+
	var isIE   = document.all && document.all.item && !isO; //Microsoft Internet Explorer 4+
	var isIE5  = isIE && isDOM; //MSIE 5+
	
	function quoteIt(str, author, email) {
		document.post.text.value = document.post.text.value + "<[**"+<?= ($engine->getConfiguration()->mailto_in_quoted_comments?"\"[[mailto:\"+email+\" \"+":"") ?> author+"<?= ($engine->getConfiguration()->mailto_in_quoted_comments?"]]":"") ?>**: "+str.replace(/<br \/>/i, "\n")+"]>";
		document.post.text.focus();
	}

	function setCookie(cookieName, cookieValue, nDays) {
		var today = new Date();
		var expire = new Date();
		if (nDays==null || nDays==0) {
			nDays=1;
		}
		expire.setTime(today.getTime() + 3600000*24*nDays);
		document.cookie = cookieName+"="+escape(cookieValue) + ";expires="+expire.toGMTString();
	}

	function hideIt(elementName, dontSave) {
		if (document.getElementById(elementName).style.display == "none") {
        		document.getElementById(elementName).style.display = "";
        		if (!dontSave) {
				setCookie(elementName, "xxx", 365*10);
			}
		} else {
        		document.getElementById(elementName).style.display = "none";
        		if (!dontSave) {
				setCookie(elementName, "none", 365*10);
			}
		}
	}

	function setFocus(elementName) {
		document.getElementById(elementName).focus();
	}

	function cutStr(aStr, aValue) {
		return aStr.substring(0, (aStr.indexOf(aValue)-2))+aStr.substring((aStr.indexOf(aValue)+aValue.length), aStr.length);
	}

	function addKey(aValue) {
		if (aValue) {
			if (document.post.keys.value) {
				if (document.post.keys.value.indexOf(aValue) < 0) {
					document.post.keys.value = document.post.keys.value+"; "+aValue;
				} else {
					document.post.keys.value = cutStr(document.post.keys.value, aValue);
				}
			} else {
				document.post.keys.value = aValue;
			}
		}
	}

	function confirmIt(url) {
		if (confirm('<?php print $engine->getI18N()->sure; ?>')) {
			window.location.href = url;
		}
	}

	function defineSomething() {
		this.area = document.post.text;
		if (isMZ || isO8) {
			this.top = this.area.scrollTop;
		}
		if ((!isO) || isO8) {
			this.text = this.area.value.replace(/\r/g, "");
			this.ss = this.area.selectionStart;
			this.se = this.area.selectionEnd;
			this.sel_before = this.text.substr(0, this.ss);
			this.sel_after = this.text.substr(this.se);
			this.sel = this.text.substr(this.ss, this.se - this.ss);
			this.str = this.sel_before + this.sel + this.sel_after;
		}
	}

	function addTag(Tag1, Tag2) {
		defineSomething();
		if ((Tag1) && (Tag2)) {
			if (isMZ || isO8) {
				this.area.value = this.sel_before + Tag1 + this.sel + Tag2 + this.sel_after;
				selPos = Tag1.length + this.sel_before.length + this.sel.length + Tag2.length;
				this.area.setSelectionRange(this.sel_before.length, selPos);
				this.area.scrollTop = this.top;
			} else if ((isO) && (!isO8)) {
				document.getElementById("text").value = document.getElementById("text").value + " "+Tag1+" some text "+Tag2+" ";
			} else {
				this.area.focus();
				sel = document.selection.createRange();
				sel.text = Tag1+sel.text+Tag2;
			}
		}
		this.area.focus();
	}
	
	function createLink() {
		defineSomething();
		link = prompt("<?= $engine->getI18N()->link; ?>:", "http://" + this.sel);
		desc = prompt("<?= $engine->geti18N()->description; ?>:", this.sel);
		if (link) {
			if ((isO) && (!isO8)) {
				document.getElementById("text").value = document.getElementById("text").value + " " + ('[[' + link + (desc == null?'':' ') + desc + ']]') +" ";
			} else {
				this.area.value = this.sel_before + ('[[' + link + (desc == null?'':' ') + desc + ']]') + this.sel_after;
			}
		}
		this.area.focus();
	}
-->
  </script>
 </head>
<? if ($engine->getConfiguration()->debug_mode): ?>
 <a onClick="hideIt('debug_info');" style=" cursor: pointer; "><img src="images/icon_arrow.gif" /></a>
 <div style="display : none; position : absolute; width : 65%; height : 30%; overflow : visible; background : #DDDDDD; color : #333333; border : 3px double #000000; line-height : 7px; z-index : 1000; " id="debug_info">
  <pre><br />
  <? if (!is_null($engine->getSession()->user['name'])): ?>

   <strong>$session->user['name']</strong>	= <?= $engine->getSession()->user['name']; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->user['mail'])): ?>

   <strong>$session->user['mail']</strong>	= <?= $engine->getSession()->user['mail']; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->user['rights'])): ?>

   <strong>$session->user['rights']</strong>	= <?= $engine->getSession()->user['rights']; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->module)): ?>

   <strong>$session->module</strong>		= <?= $engine->getSession()->module; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->action)): ?>

   <strong>$session->action</strong>		= <?= $engine->getSession()->action; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->sub)): ?>

   <strong>$session->sub</strong>		= <?= $engine->getSession()->sub; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->board)): ?>

   <strong>$session->board</strong>		= <?= $engine->getSession()->board; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->id)): ?>

   <strong>$session->id</strong>			= <?= $engine->getSession()->id; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->tid)): ?>

   <strong>$session->tid</strong>		= <?= $engine->getSession()->tid; ?><br />
  <? endif; ?>
  <? if (!is_null($engine->getSession()->ids)): ?>

   <strong>$session->ids</strong>		= <?= $engine->getSession()->ids; ?><br />
  <? endif; ?>

  </pre>
 </div>
<? endif; ?>

<?php
	$engine->letsGo();
?>
</html>
