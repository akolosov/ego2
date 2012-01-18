<?php
	    print "<span class=\"topic\"><nobr>";
            print "<a href=\"".$session->utils->makeHRURL("?module=comments&action=show&board=".$session->board."&tid=".$comment_data[0])."\">".$comment_title."</a> (".$comment_data[1].")";
            print "</nobr></span><br />\n";
?>