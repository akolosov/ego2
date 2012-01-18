<?php
	    print "<span class=\"topic\"><nobr>";
            print "<a href=\"".$session->utils->makeHRURL("?module=comments&action=show&board=$comment_data[0]&tid=$comment_data[1]")."\">$comment_title</a> (".$comment_data[2].")";
            print "</nobr></span><br />\n";
?>