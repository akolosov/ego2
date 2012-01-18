<!-- $Id: header.php,v 1.1 2005/05/11 07:38:28 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>
        <tr>
         <td id="header" align="left" valign="middle">
	 <a href="<?= $session->utils->makeHRURL("?module=blog&action=show&id=".$session->blog['id']); ?>" title="[<?= $i18n->more; ?>]"><span class="topichead" align="left"><span class="small"><?= $session->blog['title']; ?> | </span><span class="verysmall"><?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a><? endif; ?></span></span></a>
         </td>
         <td id="header" align="right" valign="middle">
	  <nobr>
	  <? if ((!empty($session->blog['keys'])) && ($config->use_keywords)): ?>
	   <a onClick="hideIt('keywords<?= $session->blog['id']; ?>', true)" style=" cursor : pointer; " title="[<?= $i18n->keysubjs; ?> &amp; <?= $i18n->categories; ?>]"><img src="images/<?= $session->style; ?>/icon-keys.png" class="actions" /></a>
	  <? endif; ?>
	  <? if (!empty($session->blog['addons'])): ?>
	   <a onClick="hideIt('addons<?= $session->blog['id']; ?>', true)" style=" cursor : pointer; " title="[<?= $i18n->addons; ?> &amp; <?= $i18n->links; ?>]"><img src="images/<?= $session->style; ?>/icon-addons.png" class="actions" /></a>
	  <? endif; ?>
	  <? if (((($session->security->canUser($session->module, $config->right_to_change)) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && ($session->module <> "comments")): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=edit&id=".$session->blog['id']); ?>" title="[<?= $i18n->change; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-edit.png" class="actions" /></a><? endif; ?>
	  <? if ((((($session->security->canUser($session->module, $config->right_to_delete)) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && empty($session->blog['del'])) && ($session->module <> "comments")): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=delete&id=".$session->blog['id']); ?>')" title="[<?= $i18n->delete; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-delete.png" class="actions" /></a><? endif; ?>
	  <? if ((((($session->security->canUser($session->module, $config->right_to_delete)) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && (!empty($session->blog['del']))) && ($session->module <> "comments")): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=undelete&id=".$session->blog['id']); ?>')" title="[<?= $i18n->undelete; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-undelete.png" class="actions" /></a><? endif; ?>
	  <? if ((($session->security->canUser($session->module, $config->right_to_bookmark)) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=append&id=".$session->blog['id']); ?>" style=" cursor : pointer; " title="[<?= $i18n->tobookmarks; ?>]"><img src="images/<?= $session->style; ?>/icon-bm.png" class="actions" /></a><? endif; ?>	  
	  <? if ((($session->security->canUser($session->module, $config->right_to_comment)) || ($session->user['isadmin'])) && ($config->use_comments) && (in_array($session->blog['category'], $config->categories_allowed_to_comment[$session->module])) && ($session->module <> "comments")): ?><a href="<?= $session->utils->makeHRURL("?module=comments&action=show&tid=".$session->blog['id']."&board=1#cf"); ?>" title="[<?= $i18n->comment." '".$session->blog['title']."'".$i18n->inforum; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-comments.png" class="actions" /></a><span class="verysmall" valign="middle">&nbsp;(<?= $comments_count; ?>)</span><? endif; ?>
	  <? if ((($session->security->canUser($session->module, $config->right_to_comment)) || ($session->user['isadmin'])) && ($config->use_comments) && (in_array($session->blog['category'], $config->categories_allowed_to_comment[$session->module])) && ($session->module == "comments")): ?><span class="maintance"><a href="javascript:quoteIt('<?= $session->blog['quoted']; ?>', '<?= $author_name; ?>', '<?= $author_email; ?>'); " style=" cursor : pointer; " title="[<?= $i18n->cite; ?>]"><img src="images/<?= $session->style; ?>/icon-quote.png" class="actions" /></a></span><? endif; ?></nobr>
	 </td>
        </tr>
<?php
  if ((!empty($session->blog['keys'])) && ($config->use_keywords)) {
    print "<tr id=\"keywords".$session->blog['id']."\" style=\" display : none; \">";
    print "<td id=\"header\" align=\"right\" valign=\"middle\" colspan=\"2\">";
    print "<table width=\"100%\" align=\"center\"><tr>";
    print "<td align=\"center\" valign=\"middle\" class=\"border\">";
    print "<span class=\"parthead\">".$i18n->keys."</span>";
    print "</td>";
    foreach((split(";", $session->blog['keys'])) as $session->blog['key']) {
      $session->blog['key'] = stripslashes(str_replace("\"", "", str_replace("'", "", trim(chop($session->blog['key'])))));
      if (!empty($session->blog['key'])) {
    	print "<td align=\"center\" valign=\"middle\" class=\"navcell\">";
    	print " <span class=\"topickeys\">";
	if (strlen($session->blog['key']) > $config->max_key_length) {
          $session->blog['key_title'] = substr_x($session->blog['key'], 0, $config->max_key_length)."...";
        } else {
          $session->blog['key_title'] = $session->blog['key'];
        }
        print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=".$session->blog['key'])."\" title=\"".$i18n->keysubj.": ".$session->blog['key']."\">[".$session->blog['key_title']."]</a>";
	print "</span>";
    	print "</td>";
      }
    }
    print "</tr></table>";
    print "</td>";
    print "</tr>";
  }
  if (!empty($session->blog['addons'])) {
    print "<tr id=\"addons".$session->blog['id']."\" style=\" display : none; \">";
    print "<td id=\"header\" align=\"right\" valign=\"middle\" colspan=\"2\">";
    print "<table width=\"100%\" align=\"center\"><tr>";
    print "<td align=\"center\" valign=\"middle\" class=\"border\">";
    print "<span class=\"parthead\">".$i18n->addons."</span>";
    print "</td>";
    foreach((split(";", $session->blog['addons'])) as $session->blog['addon_tmp']) {
      $session->blog['addon'] = split(",", $session->blog['addon_tmp']);
      if (!empty($session->blog['addon'][1])) {
    	print "<td align=\"center\" valign=\"middle\" class=\"navcell\">";
    	print " <span class=\"topiclinx\">";
        print "<a href=\"".$session->blog['addon'][1]."\" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":"").">[".$session->blog['addon'][0]."]</a>";
	print "</span>";
    	print "</td>";
      }
    }
    print "</tr></table>";
    print "</td>";
    print "</tr>";
  }
?>

<!-- eof $Id: header.php,v 1.1 2005/05/11 07:38:28 hunter Exp $ -->
