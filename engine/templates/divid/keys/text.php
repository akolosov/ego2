<?php
            print "<div align=\"left\">";
            print "<a href=\"".$session->utils->makeHRURL("?module=".$module."&action=show&key=$key_data[1]")."\" title=\"[".$i18n->keysubj.": ".$key_data[1]."]\" class=\"topic\">$key_data[1]</a> (".(count($keys_id)-1).")";
	    
		if (($config->export_to_rss) && (in_array($module, $config->export_in_modules))) {
			print "</div><div align=\"right\"><a href=\"".$session->utils->makeHRURL("?module=".$module."&key=$key_data[1]&action=rss20")."\"><img align=\"middle\" border=\"0\" src=\"/images/rss.png\" /></a>";
		}
		
		if (($config->export_to_atom) && (in_array($module, $config->export_in_modules))) {
			print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$module."&key=$key_data[1]&action=atom03")."\"><img align=\"middle\" border=\"0\" src=\"/images/atom.png\" /></a>";
		}	    
            print "</div>\n";
?>