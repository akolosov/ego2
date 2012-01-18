<?php

class cAddonsContent extends cCoreClass {

	function __construct($a_owner) {
		parent::__construct($a_owner, $a_owner->_debug);
	}
	
	function showContent() {

		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();

		if (file_exists($config->styles_modules_path."/".$session->style."/a_addons.php")) {
			require($config->styles_modules_path."/".$session->style."/a_addons.php");
		}
	}

	function auth() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if (file_exists($config->styles_modules_path."/".$session->style."/a_auth.php")) {
			require($config->styles_modules_path."/".$session->style."/a_auth.php");
		}
	}
	
	function search() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if (file_exists($config->styles_modules_path."/".$session->style."/a_search.php")) {
			require($config->styles_modules_path."/".$session->style."/a_search.php");
		}
	}
	
	function visuals() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if (file_exists($config->styles_modules_path."/".$session->style."/a_visuals.php")) {
			require($config->styles_modules_path."/".$session->style."/a_visuals.php");
		}
	}
	
	function calendar() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if ((file_exists($config->calendars_data_path."/".$session->module)) && ($config->use_calendars) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))) {
		
			if (file_exists($config->styles_modules_path."/".$session->style."/calendars/header.php")) {
				require($config->styles_modules_path."/".$session->style."/calendars/header.php");
			}
			
			if ($session->month == 1) {
				$pmon = 12; $pyear = $session->year-1;
			} else {
				$pmon = $session->month-1; $pyear = $session->year;
			}
			
			if ($session->month == 12) {
				$nmon = 1; $nyear = $session->year+1;
			} else {
				$nmon = $session->month+1; $nyear = $session->year;
			}
			
			$pn = array("&laquo;&laquo;&laquo;&laquo;"=>$session->utils->makeHRURL("?module=".$session->module."&action=show&mounth=".((strlen($pmon)==1)?"0".$pmon:$pmon).".".$pyear."&sub=all"),
					"&raquo;&raquo;&raquo;&raquo;"=>$session->utils->makeHRURL("?module=".$session->module."&action=show&mounth=".((strlen($nmon)==1)?"0".$nmon:$nmon).".".$nyear."&sub=all"));
			
			print $this->generateCalendar($session->year, $session->month, $session->days, 3, $session->utils->makeHRURL("?module=".$session->module."&action=show&mounth=".(strlen($session->month)==1?"0".$session->month:$session->month).".".$session->year."&sub=all"), 1, $pn);
			print "&nbsp;";
			print "</td>\n";
			print "</tr>\n";
			if (file_exists($config->styles_modules_path."/".$session->style."/calendars/footer.php")) {
				require($config->styles_modules_path."/".$session->style."/calendars/footer.php");
			} else {
				print "<tr>\n";
				print "<td>&nbsp;</td>\n";
				print "</tr>\n";
			}
		}
  	}
	
	function keys() {
		$session = $this->_owner->getSession();
		$session->utils->printKeysList();
	}
	
	function comments() {
		$session = $this->_owner->getSession();
		$session->utils->printCommentsList();
	}

	function bookmarks() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$session->utils->printBookmarksList($config->bookmarks_by_modules[$session->module]." ".$session->user['name']);
	}
	
	function menu() {
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n	 = $this->_owner->getI18N();
		
		if (file_exists($config->styles_modules_path."/".$session->style."/a_menu.php")) {
			require($config->styles_modules_path."/".$session->style."/a_menu.php");
		}
	}	
	
	function generateCalendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
		$config  = $this->_owner->getConfiguration();
		$session = $this->_owner->getSession();
		$i18n    = $this->_owner->getI18N();
	
		$first_of_month = gmmktime(0, 0, 0, $month, 1, $year);
		#remember that mktime will automatically correct if invalid dates are entered
		# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
		# this provides a built in "rounding" feature to generate_calendar()
	
		$day_names = array(); #generate all the day names according to the current locale
		
		for ($n=0, $t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) { #January 4, 1970 was a Sunday
			$day_names[$n] = ucfirst(gmstrftime('%A', $t)); #%A means full textual day name
		}
	
		list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));
		
		$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
		
		$title   = ucfirst($month_name).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names
	
		#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
		@list($p, $pl) = each($pn);
		@list($n, $nl) = each($pn); #previous and next links, if applicable
		
		if ($p) {
			$p = '<span class="topiclinx">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		
		if ($n) {
			$n = '&nbsp;&nbsp;&nbsp;&nbsp;<span class="topiclinx">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
		}
		
		if (file_exists($config->styles_modules_path."/".$session->style."/calendars/title.php")) {
			require($config->styles_modules_path."/".$session->style."/calendars/title.php");
		}
	
		if($weekday > 0) { 
			$calendar .= '<td class="rb-border" colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
		}
		
		for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {
		if ($weekday == 7) {
			$weekday   = 0; #start a new week
			$calendar .= "</tr>\n<tr>";
		}
		
		if (file_exists($config->styles_modules_path."/".$session->style."/calendars/text.php")) {
			require($config->styles_modules_path."/".$session->style."/calendars/text.php");
		}
		
		}
		if ($weekday != 7) {
			$calendar .= '<td class="rb-border" colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days
		}
		return $calendar."</tr>\n</table>\n";
	}

}

?>