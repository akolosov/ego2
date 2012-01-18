    <tr>
    <? if ($session->sub <> "all"): ?>
     <td class="t-border" align="right" valign="middle" colspan="2" id="footer">
      <span class="topiclinx">
       <a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"); ?>">[<?= $i18n->allbookmarks; ?>]</a>
    <? else: ?>
     <td align="right" valign="middle" colspan="2" id="footer">
      <span class="topiclinx">
	&nbsp;
    <? endif; ?>
      </span>
     </td>
    </tr>