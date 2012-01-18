<?php
            print "<tr><td align=\"left\">";
            print "<a href=\"".$session->utils->makeHRURL($bookmark_data[3])."\"".((trim($bookmark_data[2]) == $config->external_link_name)?" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":""):"")."  title=\"[".$i18n->site_modules[$bookmark_data[2]].": ".$bookmark_desc.(empty($bookmark_group)?"":" (".$bookmark_group.")")."]\" class=\"topic\">".$bookmark_title."</a>";

	    if (!empty($bookmark_feed)) {
		print "</td><td align=\"right\"><a href=\"".trim($bookmark_feed)."\" ".((trim($bookmark_data[2]) == $config->external_link_name)?" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":""):"")." title=\"[".$i18n->xmlfeeds." '".$bookmark_desc.(empty($bookmark_group)?"":" (".$bookmark_group.")")."', ".$i18n->site_modules[$bookmark_data[2]]."]\"><img align=\"middle\" border=\"0\" src=\"/images/feed.png\" /></a>";
	    }
            print "</td></tr>\n";
?>