<? if (($config->use_search) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin'])) && (in_array($session->module, $config->search_in_modules)) ): ?>
     <tr>
      <td class="title" id="header" align="left" valign="middle" >
       <span class="parthead"><a onClick="hideIt('search01'); hideIt('search02'); " style=" cursor: pointer; "><?= $i18n->search; ?></a></span>
      </td>
     </tr>
     <tr id="search01" style=" display : <?= $_COOKIE['search01']; ?>; ">
      <td class="b-border" id="addons" align="center" valign="middle">
        <br /><form method="<?= $config->default_method; ?>" action="<?= $session->utils->makeHRURL("?module=".$session->module); ?>">
        <nobr><input type="text" size="20" maxlength="255" name="search" maxlength="170" value="<?= $session->search; ?>" style=" width:75%; " title="[<?= $i18n->searchdesc; ?>]"></input>&nbsp;
	<input type="submit" style=" width : 20%; " value="<?= $i18n->search; ?>" title="[<?= $i18n->searchdesc; ?>]" src="images/<?= $session->style; ?>/icon-find.png"></input></nobr></form>
	<br />
      </td>
     </tr>
     <tr>
       <td id="addons" align="left" valign="middle">&nbsp;</td>
      </tr>
<? endif; ?>
