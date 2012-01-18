<!-- $Id: a_addons.php,v 1.1 2005/05/11 07:37:31 hunter Exp $ -->
     <td align="center" valign="top" width="20%">
      <table align="right" valign="top" border="0" cellspacing="0" cellpadding="0" width="100%">
       <tbody>
	<tr>
	 <td>&nbsp;</td>
	</tr>
<?php
	foreach ($config->in_addons_sidebar as $addon) {
		if (in_array($addon, get_class_methods(get_class($this)))) {
			$this->$addon();
		}
	}
?>	 
	<tr>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td id="header" align="left"><span class="parthead"><?= $i18n->links; ?></span></td>
	</tr>
	<tr>
	 <td class="h-border" id="text" align="center">
      <nobr><a href="http://www.debian.org/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/debian-mini.png" border="0" title="powered by Debian GNU/Linux" /></a>&nbsp;<a href="http://www.catb.org/hacker-emblem/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="http://www.catb.org/hacker-emblem/hacker.png" border="0" title="hacker emblem" /></a><br /><a href="http://www.npj.ru/hunter/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/npj-user.png" border="0" title="NPJ user" /></a>&nbsp;<a href="http://npj.ru/foreign/rss/ego/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/npj-syndicated.png" border="0" title="syndicated by NPJ" /></a><br />
<? if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))): ?><? if ($config->ngine_validities['rss20']): ?><a href="http://feedvalidator.org/check.cgi?url=<?= $config->site_url.$session->utils->makeHRURL($session->module."&action=rss20"); ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/rss-valid.png" border="0" title="RSS 2.0 Valid" /></a>&nbsp;<? endif; ?><a href="<?= $session->utils->makeHRURL($session->module."&action=rss20"); ?>"><img src="images/rss2.gif" border="0" title="RSS 2.0 feed" /></a><br /><? endif; ?>
<? if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))): ?><? if ($config->ngine_validities['atom03']): ?><a href="http://feedvalidator.org/check.cgi?url=<?= $config->site_url.$session->utils->makeHRURL($session->module."&action=atom03"); ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/atom-valid.png" border="0" title="ATOM 0.3 Valid" /></a>&nbsp;<? endif; ?><a href="<?= $session->utils->makeHRURL($session->module."&action=atom03"); ?>"><img src="images/atom-03.png" border="0" title="ATOM 0.3 feed" /></a><br /><? endif; ?>
<? if ($config->ngine_validities['css20']): ?><a href="http://jigsaw.w3.org/css-validator/validator/referer" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/css-valid.png" border="0" title="CSS 2.0 Valid" /></a>&nbsp;<? endif; ?><? if ($config->ngine_validities['xhtml4x']): ?><a href="http://validator.w3.org/check/referer" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/xhtml-valid.png" border="0" title="xHTML 4.x Valid" /></a>&nbsp;<? endif; ?></nobr>
	 </td>
	</tr>
       </tbody>
      </table>
     </td>
<!-- eof $Id: a_addons.php,v 1.1 2005/05/11 07:37:31 hunter Exp $ -->
