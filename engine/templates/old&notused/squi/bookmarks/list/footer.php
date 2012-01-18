<?php
    		print "<span class=\"topic\">...</span><br />";
		print "</td>";
    		print "</tr>";
    		print "<tr id=\"".$bm_footer."\" style=\" display : ".$_COOKIE[$bm_footer]."; \">\n";
		print "<td class=\"t-border\" id=\"addons\" align=\"right\" valign=\"middle\">";
    		print "<span class=\"topiclinx\"><nobr>";
    		print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all")."\">[".$i18n->allbookmarks."]</a>";
    		print "</nobr></span>\n";
		print "</td>\n";
	        print "</tr>\n";
		print "<tr>\n";
	        print "<td>&nbsp;</td>\n";
		print "</tr>\n";
?>