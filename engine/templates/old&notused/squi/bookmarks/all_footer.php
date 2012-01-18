<!-- $Id: all_footer.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
    <tr>
     <td class="border" align="left" valign="middle" colspan="2" id="footer">
      <span class="topiclinx">
    <? if ($session->sub <> "all"): ?>
       <a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"); ?>">[<?= $i18n->allbookmarks; ?>]</a>
    <? else: ?>
	&nbsp;
    <? endif; ?>
      </span>
     </td>
    </tr>
<!-- eof $Id: all_footer.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
