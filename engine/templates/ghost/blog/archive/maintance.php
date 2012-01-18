	<tr>
         <td width="100%" id="header" align="center" valign="middle" colspan="2">
	  <table width="100%" align="center">
	   <tr>
	    <td align="center" valign="middle" class="navcell" id="arrows"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&first=".($session->first+$session->count)); ?>">&nbsp;&laquo;&laquo;&laquo;&laquo;&nbsp;</a></td>   
	    <td align="center" valign="middle" class="navcell" <?= (($session->sub=="all")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=archive&sub=all"); ?>"><?= $i18n->all; ?></a></span></td>
	    <td align="center" valign="middle" class="navcell" <?= (($session->sub=="last")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=last"); ?>"><?= $i18n->last; ?></a></span></td>	   
	    <td align="center" valign="middle" class="navcell" <?= (($session->action=="archive")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=archive"); ?>"><?= $i18n->archive; ?></a></span></td>
	    <? if (($session->security->canUser($session->module, $config->right_to_write) == 1) || ($session->user['isadmin'])): ?><td align="center" valign="middle" class="navcell" <?= (($session->sub=="add")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=add"); ?>"><?= $i18n->add; ?></a></span></td>
	    <? endif; ?>
	    <? if ((($session->security->canUser($session->module, $config->right_to_read) == 1) || ($session->user['isadmin'])) && ($config->use_keywords)): ?><td align="center" valign="middle" class="navcell" <?= (($session->action=="keys")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=keys&sub=all"); ?>"><?= $i18n->keys; ?></a></span></td>
	    <? endif; ?>
	    <? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><td align="center" valign="middle" class="navcell" <?= (($session->action=="bookmarks")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"); ?>"><?= $i18n->bookmarks; ?></a></span></td>
	    <? endif; ?>
	    <td align="center" valign="middle" class="navcell" id="arrows"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&first=".($session->first-$session->count)); ?>">&nbsp;&raquo;&raquo;&raquo;&raquo;&nbsp;</a></td>   
	   </tr>
	  </table>
         </td>
       </tr>
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>       
