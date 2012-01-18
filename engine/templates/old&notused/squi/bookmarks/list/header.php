<?php
    print "<tr>\n";
    print "<td class=\"border\" id=\"addons\" ".$session->header_style." align=\"right\" valign=\"middle\"><span class=\"topichead\">..:: ".$i18n->bookmarks." </span><span class=\"topic\"> (".(!empty($config->language[$user])?$config->language[$user]:$user).")</span></td>\n";
    print "</tr>\n";
    print "<tr>\n";
    print " <td class=\"rbl-border\" id=\"addons\" ".$session->body_style." align=\"right\" valign=\"middle\">\n";
?>