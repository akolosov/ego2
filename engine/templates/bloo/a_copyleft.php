<!-- $Id: a_copyleft.php,v 1.1 2005/05/11 07:37:31 hunter Exp $ -->
  <tr>
    <td width="100%" height="100%" align="right" valign="middle" colspan="3">
      <?= $session->utils->setCounter(); ?>
      <br /><hr /><span class="hits"><nobr>Powered by <a href="<?= $session->utils->makeHRURL($config->ngine_url); ?>"><?= $config->ngine_name."  v".$config->ngine_version; ?></a>. &copy;opyLeft &amp; &copy;odeRight by <a href="mailto:<?= $session->utils->hideEMail($config->ngine_author_email); ?>"><?= $config->ngine_author; ?></a> (icq#<a href="http://web.icq.com/wwp/1,,,00.html?Uin=5005747" target="_blank"><?= $config->ngine_author_uin; ?></a>). No Rights Reserved.</nobr></span><br />
      <span class="hits">Except where noted otherwise, <strong>all content</strong> on this site is licensed under a <a href="http://creativecommons.org/licenses/by/2.0/" target="_bank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>Creative Commons license</a>.</span><br />
    <? if ($config->use_wackoformatter): ?>
        <span class="hits">Additionaly powered by <a href="http://wackowiki.com/projects/wackoformatter" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>WackoFormatter</a>. Copyright &copy; by <a href="http://wackowiki.com/team" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>WackoWiki team</a>. All rights reserved.</span><br />
    <? endif; ?>
    <?  if ($config->use_typografica): ?>
        <span class="hits">Additionaly powered by <a href="http://www.pixel-apes.com/typografica" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>typografica</a>. Copyright &copy; by <a href="http://www.pixel-apes.com/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>Pixel-Apes</a>. All rights reserved.</span><br />
    <? endif; ?>
    <span class="hits"><strong><?= $config->ngine_name; ?></strong> released without warranty under the terms of the <a href="http://www.opensource.org/licenses/artistic-license.php" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>Artistic License</a>.</span>
    </td>
  </tr>
<!-- eof $Id: a_copyleft.php,v 1.1 2005/05/11 07:37:31 hunter Exp $ -->
