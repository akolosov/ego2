<?php
        print "     <span class=\"topic\"><nobr>\n";
        print "      <a href=\"".$session->utils->makeHRURL("?module=".$module."&action=show&key=$key_data[1]")."\">$key_data[1]</a> (".(count($keys_id)-1).")\n";
        print "     </nobr></span><br />\n";
?>