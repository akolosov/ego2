  <tr>
    <td id="header" width="60%" align="left" valign="middle" colspan="3">
      <table width="100%" align="center" id="navitable"><tr>
      <?php
        $count = count($config->ngine_modules);
	$mwidth = 100 - (!is_null($session->key)?40:0) - (!is_null($session->search)?40:0);
	if ($count > 1) {
	    $width = (integer)($mwidth/$count);
	    foreach ($config->ngine_modules as $module) {
		if ($session->security->canUser($module, $config->right_to_read)) {
		    print "<td align=\"center\" valign=\"middle\" class=\"navcell\" width=\"".$width."%\" ".(($session->module==$module)?" id=\"current\"":"")."><span class=\"maintance\"><a href=\"".$session->utils->makeHRURL("?module=".$module.(($module == "comments")?"&board=".$session->board:""))."\">".$i18n->site_modules[$module]."</a></span></td>";
		}
	    }
	}
      ?>
	<? if ((!is_null($session->key)) && ($config->use_keywords) && ($session->action <> "add") && ($session->action <> "edit")): ?>
	<td align="center" valign="middle" width="30%"><span class="maintance"><strong><?= $i18n->key; ?>: </strong><?= $session->key; ?></span>
<?php
	if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))) {
		print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&key=".$session->key."&action=rss20")."\"  class=\"topic\"><img align=\"middle\" border=\"0\" src=\"/images/rss.png\" /></a>";
	}
	if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))) {
		print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&key=".$session->key."&action=atom03")."\"  class=\"topic\"><img align=\"middle\" border=\"0\" src=\"/images/atom.png\" /></a>";
	}
	if ($config->use_technorati) {
		print "&nbsp;&nbsp;<a href=\"http://technorati.com/tag/".$session->key."\" target=\"_blank\"><img align=\"middle\" border=\"0\" src=\"/images/tags.png\" /></a>";
	}
?>
	</td><? endif; ?>
	<? if ((!is_null($session->search)) && ($config->use_search)): ?>
	<td align="center" valign="middle" width="30%"><span class="maintance"><strong><?= $i18n->search; ?>: </strong><?= $session->search; ?></span>
<?php
	if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))) {
		print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&search=".$session->search."&action=rss20")."\"  class=\"topic\"><img align=\"middle\" border=\"0\" src=\"/images/rss.file:///var/garbage/projects/ego2/engine/templates/ghost/a_navigation.phppng\" /></a>";
	}
	if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))) {
		print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&search=".$session->search."&action=atom03")."\"  class=\"topic\"><img align=\"middle\" border=\"0\" src=\"/images/atom.png\" /></a>";
	}
	if ($config->use_technorati) {
		print "&nbsp;&nbsp;<a href=\"http://technorati.com/tag/".$session->search."\" target=\"_blank\"><img align=\"middle\" border=\"0\" src=\"/images/tags.png\" /></a>";
	}
?>
	</td><? endif; ?>      
      </tr>
      </table>
    </td>
  </tr>
