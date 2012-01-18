<!-- $Id: footer.php,v 1.1 2005/05/11 07:37:52 hunter Exp $ -->
        <tr>
         <td class="t-border" width="100%" id="footer" align="right" valign="middle" colspan="2">
	  <span class="maintance"><a href="javascript:quoteIt('<?= $session->comment['quoted']; ?>', '<?= $author_name; ?>', '<?= $author_email; ?>'); ">[<?= $i18n->cite; ?>]</a>&nbsp;
          <? if ((($session->security->canUser($session->module, $config->right_to_bookmark)) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=append&board=".$session->board."&tid=".$session->tid); ?>">[<?= $i18n->tobookmarks; ?>]</a><? endif; ?></span>
         </td>
       </tr>
<!-- eof $Id: footer.php,v 1.1 2005/05/11 07:37:52 hunter Exp $ -->
