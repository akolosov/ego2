<? if (($config->use_search) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin']))): ?>
      <tr>
       <td id="addons" align="left" valign="middle"><span class="parthead"><?= $i18n->search; ?></span></td>
      </tr>
      <tr>
       <td class="h-border" id="addons" align="center" valign="middle">
        &nbsp;<form method="POST" action="<?= $session->module; ?>">
        <nobr><input type="text" size="19" name="search" maxlength="170" value="<?= $session->search; ?>" style=" width:75%; " title="[<?= $i18n->searchdesc; ?>]"></input>&nbsp;
	<input type="submit" style=" width:20%; " value="<?= $i18n->search; ?>" title="[<?= $i18n->searchdesc; ?>]"></input></nobr></form>
       </td>
      </tr>
      <tr>
       <td>&nbsp;</td>
      </tr>
<? endif; ?>
