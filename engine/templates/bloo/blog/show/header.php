<!-- $Id: header.php,v 1.1 2005/05/11 07:37:37 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>
        <tr>
         <td class="b-border" id="header" align="left" valign="middle" colspan="2">
	  <span class="topichead"><?= $session->blog['title']; ?></span>
         </td>
        </tr>
<?php
  if ((!empty($session->blog['keys'])) && ($config->use_keywords)) {
    print "<tr>";
    print "<td id=\"header\" align=\"right\" valign=\"middle\" colspan=\"2\">";
    print " <span class=\"topickeys\">";
    foreach((split(";", $session->blog['keys'])) as $session->blog['key']) {
      $session->blog['key'] = stripslashes(str_replace("\"", "", str_replace("'", "", trim(chop($session->blog['key'])))));
      if (!empty($session->blog['key'])) {
        if (strlen($session->blog['key']) > $config->max_key_length) {
          $session->blog['key_title'] = substr_x($session->blog['key'], 0, $config->max_key_length)."...";
        } else {
          $session->blog['key_title'] = $session->blog['key'];
        }
        print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=".$session->blog['key'])."\" title=\"".$i18n->keysubj.": $session->blog['key']\">[".$session->blog['key_title']."]</a>&nbsp;&nbsp;";
      }
    }
    print "</span>";
    print "</td>";
    print "</tr>";
  }
?>	  
	
<!-- eof $Id: header.php,v 1.1 2005/05/11 07:37:37 hunter Exp $ -->
