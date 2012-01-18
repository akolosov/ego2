<!-- $Id: all_footer.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
    <tr <?= $session->footer_style; ?> >
     <td class="border" align="left" valign="middle" colspan="2" id="footer">
      <span class="topic">
    <? if ($session->sub <> "all"): ?>
	<a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=keys&sub=all"); ?>">[<?= $i18n->allkeys; ?>]</a>
    <? else: ?>
	&nbsp;
    <? endif; ?>
      </span>
     </td>
    </tr>
<!-- eof $Id: all_footer.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
