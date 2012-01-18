	  <div id="submenu">
	   <ul class="menu">
	    <li class="navcell" id="arrows"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&first=".($session->first+$session->count)); ?>">&nbsp;&laquo;&laquo;&laquo;&laquo;&nbsp;</a></li>   
	    <li class="navcell" <?= (($session->sub=="all")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=all"); ?>"><?= $i18n->all; ?></a></span></li>
	    <li class="navcell" <?= (($session->sub=="last")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=last"); ?>"><?= $i18n->last; ?></a></span></li>   
	    <li class="navcell" <?= (($session->sub=="archive")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=archive"); ?>"><?= $i18n->archive; ?></a></span></li>
	    <? if (($session->security->canUser($session->module, $config->right_to_write) == 1) || ($session->user['isadmin'])): ?><li class="navcell" <?= (($session->sub=="add")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&sub=add"); ?>"><?= $i18n->add; ?></a></span></li>
	    <? endif; ?>
	    <? if ((($session->security->canUser($session->module, $config->right_to_read) == 1) || ($session->user['isadmin'])) && ($config->use_keywords)): ?><li class="navcell" <?= (($session->action=="keys")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=keys&sub=all"); ?>"><?= $i18n->keys; ?></a></span></li>
	    <? endif; ?>
	    <? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><li class="navcell" <?= (($session->action=="bookmarks")?" id=\"current\"":"")?>><span class="maintance"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=all"); ?>"><?= $i18n->bookmarks; ?></a></span></li>
	    <? endif; ?>
	    <li class="navcell" id="arrows"><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&first=".($session->first-$session->count)); ?>">&nbsp;&raquo;&raquo;&raquo;&raquo;&nbsp;</a></li>   
	   </ul>
          </div>
