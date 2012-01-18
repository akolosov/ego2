<?php
if (count($bookmarks) > $i) {
    		print "<span class=\"topic\">...</span><br />";
		print "</td>";
    		print "</tr>";
    		print "<tr>\n";
		print "<td id=\"addons\" align=\"right\" valign=\"middle\">";
    		print "<span class=\"topiclinx\"><nobr>";
    		print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all")."\">[".$i18n->allbookmarks."]</a>";
    		print "</nobr></span>\n";
}
?>