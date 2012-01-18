	<tr>
         <td align="left" valign="middle" colspan="2">
	  &nbsp;
         </td>
        </tr>
	<tr>
         <td width="100%" id="header" align="left" valign="middle" colspan="2">
            <span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=archive"); ?>"><?= "[".$i18n->archive."]"; ?></a>&nbsp;&nbsp;
	                       <a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=all"); ?>">[<?= $i18n->all; ?>]</a>&nbsp;&nbsp;
			    <? if (($session->security->canUser($session->module, $config->right_to_write) == 1) || ($session->user['isadmin'])): ?>
				<a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=add"); ?>">[<?= $i18n->add; ?>]</a>&nbsp;&nbsp;
			    <? endif; ?>
			    <? if ((($session->security->canUser($session->module, $config->right_to_read) == 1) || ($session->user['isadmin'])) && ($config->use_keywords)): ?>
				<a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=keys&sub=all"); ?>">[<?= $i18n->keys; ?>]</a>&nbsp;&nbsp;
			    <? endif; ?>
			    <? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?>
				<a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"); ?>">[<?= $i18n->bookmarks; ?>]</a>&nbsp;&nbsp;
			    <? endif; ?>
			    <? if ((!is_null($session->key)) && ($config->use_keywords)): ?>
				(<strong><?= $i18n->key; ?>: </strong><?= $session->key; ?>)
			    <? endif; ?>
			    <? if ((!is_null($session->search)) && ($config->use_search)): ?>
				(<strong><?= $i18n->search; ?>: </strong><?= $session->search; ?>)
			    <? endif; ?></span>
         </td>
       </tr>
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>       
