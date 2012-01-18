<!-- $Id: header.php,v 1.3 2005/02/10 06:09:26 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>
        <tr>
         <td class="b-border" width="30%" id="header" align="left" valign="middle">
	  <nobr><span class="topictime"><?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a><? endif; ?></span></nobr>
         </td>
         <td class="b-border" width="70%" id="header" align="right" valign="middle">
<?php
  if ((!empty($session->blog['keys'])) && ($config->use_keywords)) {
    print " <span class=\"topickeys\">";
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
  }
?>	  
         </td>
        </tr>
        <tr>
         <td id="header" align="left" valign="middle" colspan="2">
	  <span class="topichead"><?= $session->blog['title']; ?></span>
         </td>
        </tr>
	
<!-- eof $Id: header.php,v 1.3 2005/02/10 06:09:26 hunter Exp $ -->
