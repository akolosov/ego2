<!-- $Id: header.php,v 1.1 2005/05/11 07:38:43 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
       </tr>
        <tr>
         <td id="header" align="left" valign="middle" colspan=>
          <a name=<?= $session->comment['id']; ?>></a><span class="topichead"><?= $session->comment['title']; ?></span>
         </td>
         <td id="header" align="right" valign="middle">
	  <span class="parthead">
	  <? if ((($session->security->canUser($session->module, $config->right_to_delete)) && (trim($session->comment['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])): ?>
	    <? if (empty($session->comment['del'])): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=delete&id=".$session->comment['id']."&board=".$session->board."&tid=".$session->tid."#".$session->comment['id']); ?>')" title="<?= $i18n->delete; ?>"><img src="images/<?= $session->style; ?>/icon-delete.png" class="actions" /></a>
	    <? else: ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=undelete&id=".$session->comment['id']."&board=".$session->board."&tid=".$session->tid."#".$session->comment['id']); ?>')" title="<?= $i18n->undelete; ?>"><img src="images/<?= $session->style; ?>/icon-undelete.png" class="actions" /></a>
	    <? endif; ?>
	  <? endif; ?>
	  <a href="javascript:quoteIt('<?= $session->comment['quoted']; ?>', '<?= $session->comment['author_name']; ?>', '<?= $session->utils->hideEMail($session->comment['author_email']); ?>')" title="<?= $i18n->cite; ?>"><img src="images/<?= $session->style; ?>/icon-quote.png" class="actions" /></a>
	 </td>	 
       </tr>
<!-- eof $Id: header.php,v 1.1 2005/05/11 07:38:43 hunter Exp $ -->
