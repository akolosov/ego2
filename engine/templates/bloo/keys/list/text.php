<?php
            print "<span class=\"topic\"><nobr>";
            print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=$key_data[1]")."\" title=\"[".$i18n->keysubj.": ".$key_data[1]."]\">$key_title</a> (".(count($keys_id)-1).")";
            print "</nobr></span><br />\n";
?>