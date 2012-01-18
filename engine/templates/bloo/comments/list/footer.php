<?php
        print "<span class=\"topic\">...</span><br />";
        print "</td>\n";
        print "</tr>\n";
        print "<tr id=\"comments02\" style=\" display : ".$_COOKIE['comments02']."; \">\n";
        print "<td class=\"t-border\" id=\"addons\" align=\"right\" valign=\"middle\">";
        print "<span class=\"topiclinx\"><nobr>";
        print "<a href=\"".$session->utils->makeHRURL("?module=comments&action=subj")."\">[".$i18n->allcomments."]</a>";
        print "</nobr></span><br />\n";
	print "</td>\n";
        print "</tr>\n";
        print "<tr>\n";
        print "<td>&nbsp;</td>\n";
        print "</tr>\n";
?>