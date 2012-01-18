<!-- $Id: footer.php,v 1.3 2005/02/10 06:09:17 hunter Exp $ -->
	<script>
          function Delete(url) {
            if (confirm('<?php print $i18n->sure; ?>')) {
              window.location.href = url;
            }
          }
	</script>

<?php
  if ((!empty($session->blog['keys'])) && ($config->use_keywords)) {
    print "<tr>";
    print "<td width=\"15%\" id=\"footer\" align=\"left\" valign=\"middle\">";
    print "<span class=\"parthead\"><strong>".$i18n->keys."</strong></span>";
    print "</td>";
    print "<td width=\"85%\" id=\"footer\" align=\"left\" valign=\"middle\">";
    print " <span class=\"topiclinx\">:&nbsp;";
    foreach((split(";", $session->blog['keys'])) as $session->blog['key']) {
      $session->blog['key'] = stripslashes(str_replace("\"", "", str_replace("'", "", trim(chop($session->blog['key'])))));
      if (!empty($session->blog['key'])) {
        if (strlen($session->blog['key']) > $config->max_key_length) {
          $session->blog['key_title'] = substr_x($session->blog['key'], 0, $config->max_key_length)."...";
        } else {
          $session->blog['key_title'] = $session->blog['key'];
        }
        print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=".$session->blog['key'])."\" title=\"".$i18n->keysubj.": ".$session->blog['key']."\">[".$session->blog['key_title']."]</a>&nbsp;&nbsp;";
      }
    }
    print "</span>";
    print "</td>";
    print "</tr>";
  }
?>
       <?php
            if (!empty($session->blog['addons'])) {
              print "<tr>\n";
	      print "<td width=\"15%\" class=\"t-border\" id=\"footer\" align=\"left\" valign=\"middle\">\n";
	      print "<span class=\"parthead\"><strong>".$i18n->seealso."&nbsp;</strong>\n";
	      print "</span>\n</td>\n";
	      print "<td class=\"t-border\" width=\"85%\" id=\"footer\" align=\"left\" valign=\"middle\">\n";
              print "<span class=\"topiclinx\">:&nbsp;";
              foreach((split(";", $session->blog['addons'])) as $session->blog['addon_tmp']) {
                $session->blog['addon'] = split(",", $session->blog['addon_tmp']);
                if (!empty($session->blog['addon'][1])) {
                  print "<a href=\"".$session->blog['addon'][1]."\" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":"").">[".$session->blog['addon'][0]."]</a>&nbsp;&nbsp;";
                }
              }
              print "</span>";
              print "</td>\n</tr>\n";
            }
         ?>
        <tr>
         <td width="15%" class="t-border" id="footer" align="left" valign="middle">
	  <span class="parthead"><strong><?= $i18n->actions; ?>&nbsp;</strong>
	  </span>
         </td>
         <td width="85%" class="t-border" id="footer" align="left" valign="middle">
	  <span class="topiclinx">:&nbsp;<? if ((($session->security->canUser($session->module, $config->right_to_change) == 1) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=change&sub=edit&id=".$session->blog['id']); ?>">[<?= $i18n->change; ?>]</a>&nbsp;<? endif; ?>
<? if (((($session->security->canUser($session->module, $config->right_to_delete) == 1) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && empty($session->blog['del'])): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=delete&id=".$session->blog['id']); ?>')">[<?= $i18n->delete; ?>]</a>&nbsp;<? endif; ?>
<? if (((($session->security->canUser($session->module, $config->right_to_delete) == 1) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && (!empty($session->blog['del']))): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=undelete&id=".$session->blog['id']); ?>')">[<?= $i18n->undelete; ?>]</a>&nbsp;<? endif; ?>
<? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=append&id=".$session->blog['id']); ?>">[<?= $i18n->tobookmarks; ?>]</a>&nbsp;<? endif; ?>
<? if ((($session->security->canUser($session->module, $config->right_to_comment) == 1) || ($session->user['isadmin'])) && ($config->use_comments) && (in_array($session->blog['category'], $config->categories_allowed_to_comment[$session->module]))): ?><a href="<?= $session->utils->makeHRURL("?module=comments&action=show&tid=$session->blog['id']&board=1"); ?>" title="<?= $i18n->comment." '".$session->blog['title']."'".$i18n->inforum; ?>">[<?= $i18n->comment; ?>]</a> (<?= $comments_count; ?>)<? endif; ?>
	  </span>
         </td>
       </tr>
       <tr>
         <td align="left" valign="middle" colspan="2">&nbsp;</td>
        </tr>
<!-- eof $Id: footer.php,v 1.3 2005/02/10 06:09:17 hunter Exp $ -->
