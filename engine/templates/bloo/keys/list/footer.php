<?php
        print "<span class=\"topic\">...</span><br />";
        print "</td>";
        print "</tr>";
        print "<tr id=\"keys02\" style=\" display : ".$_COOKIE['keys01']."; \">\n";
        print "<td class=\"t-border\" id=\"addons\" align=\"right\" valign=\"middle\">";
        print "<span class=\"topiclinx\"><nobr>";
        print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=keys&sub=all")."\">[".$i18n->allkeys."]</a>";
        print "</nobr></span><br />\n";
        print "</td>\n";
	print "</tr>\n";
	print "<tr>\n";
	print "<td>&nbsp;<br /></td>\n";
	print "</tr>\n";
?>