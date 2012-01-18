<?php
                print "<span class=\"topic\"><nobr>";
                print "<a href=\"".$session->utils->makeHRURL($bookmark_data[3])."\"".((trim($bookmark_data[2]) == $config->external_link_name)?" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":""):"").">".$bookmark_data[1]."</a>";
                print "&nbsp;(".$i18n->site_modules[trim($bookmark_data[2])].")";
                if (empty($bookmark_data[5])) {
		    print "&nbsp;-&nbsp;<a href=\"javascript:confirmIt('".$session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=".(empty($bookmark_data[4])?"delete":"undelete")."&id=".$bookmark_data[0])."')\">[".(empty($bookmark_data[4])?$i18n->delete:$i18n->undelete)."]</a>";
                }
                print "</nobr></span><br />\n";
?>