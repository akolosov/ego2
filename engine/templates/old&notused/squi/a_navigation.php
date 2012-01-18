<!-- $Id: a_navigation.php,v 1.4 2005/04/26 07:09:41 hunter Exp $ -->
  <tr <?= $session->body_style; ?> >
    <td class="border" id="header" width="100%" align="left" valign="middle">
      <span class="topiclinx"><?php
	if (count($config->ngine_modules) > 1) {
    	    foreach ($config->ngine_modules as $module) {
		if ($session->security->canUser($module, $config->right_to_read)) {
		    print "<a href=\"".$session->utils->makeHRURL("?module=".$module)."\">[".$i18n->site_modules[$module]."]</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	    }
	}
      ?>
      </span>
    </td>
    <td class="rtb-border" id="header" width="20%" align="right" valign="middle">
     <span class="topiclinx"><nobr><a href="<?= $session->utils->makeHRURL("?language=ru"); ?>">[ru]</a>&nbsp;<a href="<?= $session->utils->makeHRURL("?language=en"); ?>">[en]</a><? if ($config->use_visual_themes): ?>&nbsp;&nbsp;<?= $i18n->theme; ?>: <select name="theme" value="?theme=<?= $session->theme; ?>" onChange="if (this.value) { document.location.href = this.value; }">
		<option value="" />
		<?= get_themes_list(true); ?>
	     </select><? endif; ?></nobr></span>
    </td>
  </tr>
<!-- eof $Id: a_navigation.php,v 1.4 2005/04/26 07:09:41 hunter Exp $ -->
