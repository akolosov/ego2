<!-- $Id: text.php,v 1.3 2005/01/31 09:32:27 hunter Exp $ -->
        <tr <?=$session->body_style; ?> >
         <td class="rbl-border" id="text" align="left" valign="top" <? if ((!$config->use_categories) || (!file_exists("images/signs/".$session->blog['category'].".png"))): ?>colspan="2"<? endif; ?>>
	   <span class="topictext"><?= chop(stripslashes($session->blog['text'])); ?></span><br />
	  <? if ($config->authors_sign): ?>
	    <br /><span class="topictext"><a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a></span>
	  <? endif; ?>
         </td>
	 <? if (($config->use_categories) && (file_exists("images/signs/".$session->blog['category'].".png"))): ?>
          <td class="rb-border" align="center" valign="middle">
	   <nobr><a href="<?= $session->utils->makeHRURL("?module=blog&category=$session->blog['category']"); ?>"><img src="images/signs/<?= $session->blog['category']; ?>.png" border="0" /></a></nobr>
          </td>
	 <? endif; ?>
        </tr>
	
<!-- eof $Id: text.php,v 1.3 2005/01/31 09:32:27 hunter Exp $ -->
