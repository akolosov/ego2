<!-- $Id: footer.php,v 1.1 2005/05/11 07:37:37 hunter Exp $ -->
	<script>
          function Delete(url) {
            if (confirm('<?php print $i18n->sure; ?>')) {
              window.location.href = url;
            }
          }
	</script>
	<?php
            if (!empty($session->blog['addons'])) {
	    
              print "<tr>\n<td class=\"t-border\" width=\"100%\" id=\"footer\" align=\"right\" valign=\"middle\" colspan=\"2\">\n";
	      print "<span class=\"maintance\">";
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
         <td class="t-border" width="100%" id="footer" align="right" valign="middle" colspan="2">
	  <span class="maintance"><? if ((($session->security->canUser($session->module, $config->right_to_change)) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=edit&id=".$session->blog['id']); ?>">[<?= $i18n->change; ?>]</a>&nbsp;<? endif; ?>
<? if (((($session->security->canUser($session->module, $config->right_to_delete)) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && empty($session->blog['del'])): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=delete&id=".$session->blog['id']); ?>')">[<?= $i18n->delete; ?>]</a>&nbsp;<? endif; ?>
<? if (((($session->security->canUser($session->module, $config->right_to_delete)) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && (!empty($session->blog['del']))): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=undelete&id=".$session->blog['id']); ?>')">[<?= $i18n->undelete; ?>]</a>&nbsp;<? endif; ?>
<? if ((($session->security->canUser($session->module, $config->right_to_bookmark)) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=append&id=".$session->blog['id']); ?>">[<?= $i18n->tobookmarks; ?>]</a>&nbsp;<? endif; ?>
<? if ((($session->security->canUser($session->module, $config->right_to_comment)) || ($session->user['isadmin'])) && ($config->use_comments) && (in_array($session->blog['category'], $config->categories_allowed_to_comment[$session->module]))): ?><a href="<?= $session->utils->makeHRURL("?module=comments&action=show&tid=".$session->blog['id']."&board=1"); ?>" title="<?= $i18n->comment." '".$session->blog['title']."'".$i18n->inforum; ?>">[<?= $i18n->comment; ?>]</a> (<?= $comments_count; ?>)<? endif; ?>
	  </span>
         </td>
       </tr>
       <tr>
         <td align="left" valign="middle" colspan="2">&nbsp;</td>
        </tr>
<!-- eof $Id: footer.php,v 1.1 2005/05/11 07:37:37 hunter Exp $ -->
