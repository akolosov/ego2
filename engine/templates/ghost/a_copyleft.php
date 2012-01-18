<!-- $Id: a_copyleft.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
  <tr>
    <td id="blog-footer" <?= $session->body_style; ?> width="100%" height="100%" align="right" valign="middle" colspan="3">
      <?=  $session->utils->setCounter(); ?>
      <?php
	if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))) {
		print "&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=rss20")."\"><img border=\"0\" src=\"/images/rss.png\" /></a>";
	}

	if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))) {
		print "&nbsp;&nbsp;<a href=\"".$session->utils->makeHRURL("?module=".$session->module."&action=atom03")."\"><img border=\"0\" src=\"/images/atom.png\" /></a>";
	}
      ?>
    </td>
  </tr>
  <tr>
    <td width="100%" align="right" valign="middle" colspan="3"><span style=" line-height : 2px; ">&nbsp;</span></td>
  </tr>
  <tr>
    <td id="blog-footer" <?= $session->body_style; ?> width="100%" height="100%" align="right" valign="middle" colspan="3">
      <span class="hits"><nobr>Powered by <a href="<?= $session->utils->makeHRURL($config->ngine_url); ?>"><?= $config->ngine_name." v".$config->ngine_version; ?></a>. &copy;opyLeft &amp; &copy;odeRight by <a href="mailto:<?= $session->utils->hideEMail($config->ngine_author_email); ?>"><?= $config->ngine_author; ?></a> (icq#<a href="http://www.icq.com/whitepages/wwp.php?uin=<?= $config->ngine_author_uin; ?>&x=21&y=16" target="_blank"><?= $config->ngine_author_uin; ?></a>). No Rights Reserved.</nobr></span><br />
      <span class="hits">Except where noted otherwise, <strong>all content on this site</strong> is licensed under a <a href="http://creativecommons.org/licenses/by/2.0/" target="_bank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>Creative Commons license</a>.</span><br />
    <? if ($config->use_wackoformatter): ?>
        <span class="hits">Additionaly powered by <a href="http://wackowiki.com/projects/wackoformatter" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>WackoFormatter</a>. Copyright &copy; by <a href="http://wackowiki.com/team" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>WackoWiki team</a>. All rights reserved.</span><br />
    <? endif; ?>
    <span class="hits"><strong><?= $config->ngine_name; ?></strong> released without warranty under the terms of the <a href="http://www.opensource.org/licenses/artistic-license.php" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>Artistic License</a>.</span><a href="http://www.yandex.ru/cy?base=0&host=<?= str_replace("http:", "", str_replace("/", "", $config->site_url)); ?>"><img src="http://www.yandex.ru/cycounter?<?= str_replace("http:", "", str_replace("/", "", $config->site_url)); ?>" align="center" width=88 height=31 alt="Яндекс цитирования" style=" display : none; "></a>
    </td>
  </tr>
<!-- eof $Id: a_copyleft.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
