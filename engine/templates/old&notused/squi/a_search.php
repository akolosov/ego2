<!-- $Id: a_search.php,v 1.2 2005/01/31 09:32:25 hunter Exp $ -->
<? if (($config->use_search) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))): ?>
<? if ($config->search_header): ?>
      <tr>
       <td class="rtl-border" id="addons" <?= $session->header_style; ?> align="right" valign="middle"><span class="topichead">..:: <?= $i18n->search; ?></span></td>
      </tr>
<? endif; ?>
      <tr>
       <td class="border" id="addons" <?= $session->body_style; ?> align="center" valign="middle">
        &nbsp;<form method="POST" action="<?= $session->module; ?>">
        <nobr><input type="text" size="19" name="search" maxlength="170" value="<?= $session->search; ?>" style=" width:75%; " title="[<?= $i18n->searchdesc; ?>]" />&nbsp;
	<input type="submit" style=" width:20%; " value="<?= $i18n->search; ?>" title="[<?= $i18n->searchdesc; ?>]" /></nobr></form>
       </td>
      </tr>
      <tr>
       <td>&nbsp;</td>
      </tr>
<? endif; ?>
<!-- eof $Id: a_search.php,v 1.2 2005/01/31 09:32:25 hunter Exp $ -->