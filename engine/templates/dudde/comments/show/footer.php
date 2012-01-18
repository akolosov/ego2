<!-- $Id: footer.php,v 1.2 2005/02/01 11:53:55 hunter Exp $ -->
        <tr>
         <td width="10%" class="t-border" id="footer" align="left" valign="middle">
          <span class="parthead">
          <strong><?= $i18n->actions; ?></strong>
          </span>
         </td>	
         <td width="90%" class="t-border" id="footer" align="left" valign="middle">
	  <span class="topiclinx">&nbsp;:<? if ((($session->security->canUser($session->module, $config->right_to_delete) == 1) && (trim($session->comment['author_name']) == trim($session->user['name']))) || ($session->user['isadmin'])): ?>
	    <? if (empty($session->comment['del'])): ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=delete&id=".$session->comment['id']."&board=".$session->board."&tid=".$session->tid); ?>')">[<?= $i18n->delete; ?>]</a>&nbsp;&nbsp;
	    <? else: ?><a href="javascript:confirmIt('<?= $session->utils->makeHRURL("?module=".$session->module."&action=show&sub=undelete&id=".$session->comment['id']."&board=".$session->board."&tid=".$session->tid); ?>')">[<?= $i18n->undelete; ?>]</a>&nbsp;&nbsp;
	    <? endif; ?>
	  <? endif; ?>
	  <a href="javascript:quoteIt('<?= $session->comment['quoted']; ?>', '<?= $session->comment['author_name']; ?>', '<?= $session->utils->hideEMail($session->comment['author_email']); ?>')">[<?= $i18n->cite; ?>]</a></span>
         </td>
       </tr>
        <tr>
         <td width="10%" class="t-border" id="footer" align="left" valign="middle" colspan="2">&nbsp;</td>	
       </tr>
<!-- eof $Id: footer.php,v 1.2 2005/02/01 11:53:55 hunter Exp $ -->
