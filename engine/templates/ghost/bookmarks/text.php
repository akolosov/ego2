<?php
            print "<tr><td align=\"left\" ".(empty($bookmark_feed)?"":" class=\"bb-border\"").">";
	    print "<a href=\"".$session->utils->makeHRURL($bookmark_data[3])."\" ".((trim($bookmark_data[2]) == $config->external_link_name)?" target=\"_blank\" class=\"topic\" ".($config->use_google_nofollow?"rel=\"nofollow\"":""):"")."  title=\"[".$i18n->site_modules[$bookmark_data[2]].": ".$bookmark_data[1].(empty($bookmark_data[7])?"":" (".$bookmark_data[7].")")."]\">".$bookmark_data[1]."</a>";
            
	    if (empty($bookmark_data[5])) {
                    print "&nbsp;-&nbsp;<a href=\"javascript:confirmIt('".$session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=".(empty($bookmark_data[4])?"delete":"undelete")."&id=".$bookmark_data[0])."')\">[".(empty($bookmark_data[4])?$i18n->delete:$i18n->undelete)."]</a>";
            }
		
	    if (!empty($bookmark_feed)) {
		print "</td><td align=\"right\" width=\"35\"><a href=\"".trim($bookmark_feed)."\" ".((trim($bookmark_data[2]) == $config->external_link_name)?" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":""):"")." title=\"[".$i18n->xmlfeeds." '".$bookmark_data[1]."', ".$i18n->site_modules[$bookmark_data[2]]."]\"><img align=\"middle\" border=\"0\" src=\"/images/feed.png\" /></a>";
	    }
?>