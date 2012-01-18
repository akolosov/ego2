  <tr>
   <td colspan="2">
   <table width="100%" height="100%"><tr>
    <td id="header" width="80%" align="left" valign="middle">
      <span class="maintance"><?php
	if (count($config->ngine_modules) > 1) {
    	    foreach ($config->ngine_modules as $module) {
		if ($session->security->canUser($module, $config->right_to_read)) {
		    print "<a href=\"".$session->utils->makeHRURL("?module=".$module)."\">[".$i18n->site_modules[$module]."]</a>&nbsp;&nbsp;";
		}
	    }
	}
      ?></span>
    </td>
    <td id="header" width="20%" align="right" valign="middle" colspan="2">
     <nobr><span class="maintance">&nbsp;<a href="<?= $session->utils->makeHRURL("?language=ru"); ?>">[ru]</a>&nbsp;<a href="<?= $session->utils->makeHRURL("?language=en"); ?>">[en]</a><? if ($config->use_visual_styles): ?>&nbsp;&nbsp;</span><span class="topic"><?= $i18n->style; ?>: <select name="theme" value="?theme=<?= $session->style; ?>" onChange="if (this.value) { document.location.href = this.value; }">
                <option value=""></option>
                <?= $session->utils->getStylesList(true); ?>
             </select><? endif; ?><? if ($config->use_visual_themes): ?>&nbsp;&nbsp;<?= $i18n->theme; ?>: <select name="theme" value="?theme=<?= $session->theme; ?>" onChange="if (this.value) { document.location.href = this.value; }">
                <option value=""></option>
                <?= $session->utils->getThemesList(true); ?>
             </select>&nbsp;<? endif; ?></span></nobr></td>
    </tr></table>
   </td>
  </tr>
