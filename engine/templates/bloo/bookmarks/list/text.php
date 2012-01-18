<?php
	    			print "<span class=\"topic\"><nobr>";
	    			print "<a href=\"".$session->utils->makeHRURL($bookmark_data[3])."\"".((trim($bookmark_data[2]) == $config->external_link_name)?" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":""):"")." title=\"[".$i18n->bookmarks.", ".$i18n->site_modules[$bookmark_data[2]].": ".$bookmark_title."]\">".$bookmark_title."</a>";
	    			print "</nobr></span><br />\n";

?>