<!-- $Id: header.php,v 1.3 2005/02/10 06:09:42 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>
        <tr>
         <td <?= $session->header_style; ?> id="header" class="border" align="left" valign="middle" colspan="2">
          <a name="<?= $session->blog['id']; ?>"></a><span class="topichead">..:: <?= $session->blog['title']; ?></span><span class="topictime">// <?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?></span>
         </td>
        </tr>
<?php
  if ((!empty($session->blog['keys'])) && ($config->use_keywords)) {
    print "<tr>";
    print " <td ".$session->footer_style." class=\"rbl-border\" id=\"header\" align=\"left\" valign=\"middle\" colspan=\"2\">";
    print "   <span class=\"topichead\">..:: ".$i18n->keys.":&nbsp;";
    foreach((split(";", $session->blog['keys'])) as $session->blog['key']) {
      $session->blog['key'] = stripslashes(str_replace("\"", "", str_replace("'", "", trim(chop($session->blog['key'])))));
      if (!empty($session->blog['key'])) {
        if (strlen($session->blog['key']) > $config->max_key_length) {
	  $session->blog['key_title'] = substr_x($session->blog['key'], 0, $config->max_key_length)."...";
	} else {
	  $session->blog['key_title'] = $session->blog['key'];
	}
        print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=$session->blog['key']")."\" title=\"".$i18n->keysubj.": $session->blog['key']\">[".$session->blog['key_title']."]</a>&nbsp;&nbsp;";
      }
    }
    print "</span>";
    print "</td>";
    print "</tr>";
  }
?>	  
<!-- eof $Id: header.php,v 1.3 2005/02/10 06:09:42 hunter Exp $ -->
