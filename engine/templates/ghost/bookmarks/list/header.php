<?php
    $bm = "bm_".$user;
    $bm_footer = $bm."_footer";
    print "<tr>\n";
    print "<td class=\"title\" id=\"header\" align=\"left\" valign=\"middle\"><span class=\"parthead\"><a onClick=\" hideIt('".$bm."'); hideIt('".$bm_footer."'); \" style=\" cursor : pointer; \">".$i18n->bookmarks."  (".(!is_null($i18n->$user)?$i18n->$user:$user).")</a></span></td>\n";
    print "</tr>\n";
    print "<tr id=\"".$bm."\" style=\" display : ".$_COOKIE[$bm]."; \">\n";
    print "<td class=\"b-border\" id=\"text\" align=\"right\" valign=\"middle\">\n";
?>
      <table align="center" width="100%" height="100%">