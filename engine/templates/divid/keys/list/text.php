<?php
            print "<div class=\"keytitle\"><a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=$key_data[1]")."\" title=\"[".$i18n->keysubj.": ".$key_data[1]."]\" class=\"topic\">$key_title</a> (".(count($keys_id)-1).")";
	    
		if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))) {
			print "</div><div class=\"keyinfo\"><a href=\"".$session->utils->makeHRURL("?module=".$session->module."&key=$key_data[1]&action=rss20")."\"><img align=\"middle\" border=\"0\" src=\"/images/rss.png\" /></a>";
		}
		
		if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))) {
			print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&key=$key_data[1]&action=atom03")."\"><img align=\"middle\" border=\"0\" src=\"/images/atom.png\" /></a></div>";
		}	    
            print "</div><br />\n";
?>
