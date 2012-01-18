<?php
    $bm = "bm_".$user;
    print "<div class=\"b-border\" id=\"header\" align=\"left\" valign=\"middle\"><span class=\"parthead\"><a onClick=\" hideIt('".$bm."'); \" style=\" cursor : pointer; \">".$i18n->bookmarks."  (".(!empty($config->language[$user])?$config->language[$user]:$user).")</a></span></div>\n";
    print "<div id=\"".$bm."\" style=\" display : ".$_COOKIE[$bm]."; \">\n";
    print "<div id=\"text\">\n";
?>