<?php
	    print "<span class=\"topic\"><nobr>";
            print "<a href=\"".$session->utils->makeHRURL("?module=comments&action=show&board=$session->comment['data'][0]&tid=$session->comment['data'][1]")."\">$session->comment['title']</a> (".$session->comment['data'][2].")";
            print "</nobr></span><br />\n";
?>