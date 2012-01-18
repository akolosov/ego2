<!-- $Id: header.php,v 1.2 2005/02/10 06:09:07 hunter Exp $ -->
        <br />
         <div id="header" align="left" valign="middle">
	 <a href="<?= $session->utils->makeHRURL("?module=comments&action=show&tid=$session->blog['id']&board=1#cf"); ?>" title="[<?= $i18n->more; ?>]"><span class="topichead"><?= $session->blog['title']; ?></span></a>
         </div>
         <div id="header" align="right" valign="middle">
	  <nobr>
	  <? if ((!empty($session->blog['keys'])) && ($config->use_keywords)): ?>
	   <a onClick="hideIt('keywords<?= $session->blog['id']; ?>')" style=" cursor : pointer; " title="[<?= $i18n->keysubjs; ?> &amp; <?= $i18n->categories; ?>]"><img src="images/<?= $session->style; ?>/icon-keys.png" class="actions" /></a>
	  <? endif; ?>
	  <? if (!empty($session->blog['addons'])): ?>
	   <a onClick="hideIt('addons<?= $session->blog['id']; ?>')" style=" cursor : pointer; " title="[<?= $i18n->addons; ?> &amp; <?= $i18n->links; ?>]"><img src="images/<?= $session->style; ?>/icon-addons.png" class="actions" /></a>
	  <? endif; ?>
	  <? if (((($session->security->canUser($session->module, $config->right_to_change) == 1) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && ($session->module <> "comments")): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=change&sub=edit&id=".$session->blog['id']); ?>" title="[<?= $i18n->change; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-edit.png" class="actions" /></a><? endif; ?>	  
	  <? if ((((($session->security->canUser($session->module, $config->right_to_delete) == 1) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && empty($session->blog['del'])) && ($session->module <> "comments")): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=delete&id=".$session->blog['id']); ?>')" title="[<?= $i18n->delete; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-delete.png" class="actions" /></a><? endif; ?>
	  <? if ((((($session->security->canUser($session->module, $config->right_to_delete) == 1) && (trim($session->blog['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])) && (!empty($session->blog['del']))) && ($session->module <> "comments")): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=undelete&id=".$session->blog['id']); ?>')" title="[<?= $i18n->undelete; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-undelete.png" class="actions" /></a><? endif; ?>
	  <? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=add&id=".$session->blog['id']); ?>" style=" cursor : pointer; " title="[<?= $i18n->tobookmarks; ?>]"><img src="images/<?= $session->style; ?>/icon-bm.png" class="actions" /></a><? endif; ?>	  
	  <? if ((($session->security->canUser($session->module, $config->right_to_comment) == 1) || ($session->user['isadmin'])) && ($config->use_comments) && (in_array($session->blog['category'], $config->categories_allowed_to_comment[$session->module])) && ($session->module <> "comments")): ?><a href="<?= $session->utils->makeHRURL("?module=comments&action=show&tid=$session->blog['id']&board=1#cf"); ?>" title="[<?= $i18n->comment." '".$session->blog['title']."'".$i18n->inforum; ?>]" style=" cursor : pointer; "><img src="images/<?= $session->style; ?>/icon-comments.png" class="actions" /></a> (<?= $comments_count; ?>)<? endif; ?>
	  <? if ((($session->security->canUser($session->module, $config->right_to_comment) == 1) || ($session->user['isadmin'])) && ($config->use_comments) && (in_array($session->blog['category'], $config->categories_allowed_to_comment[$session->module])) && ($session->module == "comments")): ?><span class="maintance"><a href="javascript:quoteIt('<?= $session->comment['quoted']; ?>', '<?= $author_name; ?>', '<?= $author_email; ?>'); " style=" cursor : pointer; " title="[<?= $i18n->cite; ?>]"><img src="images/<?= $session->style; ?>/icon-quote.png" class="actions" /></a></span><? endif; ?></nobr>
	 </div>
<?php
  if ((!empty($session->blog['keys'])) && ($config->use_keywords)) {
    print "<div id=\"keywords".$session->blog['id']."\" style=\" display : none; \">";
    print "<span class=\"parthead\">".$i18n->keys."</span>";
    foreach((split(";", $session->blog['keys'])) as $session->blog['key']) {
      $session->blog['key'] = stripslashes(str_replace("\"", "", str_replace("'", "", trim(chop($session->blog['key'])))));
      if (!empty($session->blog['key'])) {
    	print " <span class=\"topickeys\">";
	if (strlen($session->blog['key']) > $config->max_key_length) {
          $session->blog['key_title'] = substr_x($session->blog['key'], 0, $config->max_key_length)."...";
        } else {
          $session->blog['key_title'] = $session->blog['key'];
        }
        print "<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=show&key=$session->blog['key']")."\" title=\"".$i18n->keysubj.": ".$session->blog['key']."\">[".$session->blog['key_title']."]</a>";
	print "</span>";
      }
    }
    print "</div>";
  }
  if (!empty($session->blog['addons'])) {
    print "<div id=\"addons".$session->blog['id']."\" style=\" display : none; \">";
    print "<span class=\"parthead\">".$i18n->addons."</span>";
    print "</td>";
    foreach((split(";", $session->blog['addons'])) as $session->blog['addon_tmp']) {
      $session->blog['addon'] = split(",", $session->blog['addon_tmp']);
      if (!empty($session->blog['addon'][1])) {
    	print " <span class=\"topiclinx\">";
        print "<a href=\"".$session->blog['addon'][1]."\" target=\"_blank\" ".($config->use_google_nofollow?"rel=\"nofollow\"":"").">[".$session->blog['addon'][0]."]</a>";
	print "</span>";
      }
    }
    print "</div>";
  }
?>
	
<!-- eof $Id: header.php,v 1.2 2005/02/10 06:09:07 hunter Exp $ -->
