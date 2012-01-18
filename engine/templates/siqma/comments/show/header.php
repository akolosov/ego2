<!-- $Id: header.php,v 1.2 2005/01/31 09:32:24 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>
        <tr>
         <td class="b-border" width="30%" id="header" align="left" valign="middle" colspan="2">
	  <?php $config->authors_sign = true; ?>	 
	  <nobr><span class="topictime"><?= $session->comment['date']." ".$i18n->at." "; ?> <?= (!empty($session->comment['time']))?$session->comment['time']:"00:00:00"; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->comment['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->comment['author_name']; ?></a><? endif; ?></span></nobr>
	  <?php $config->authors_sign = false; ?>	 
         </td>
        </tr>
        <tr>
         <td id="header" align="left" valign="middle" colspan="2">
	  <span class="topichead"><?= $session->comment['title']; ?></span>
         </td>
        </tr>
	
<!-- eof $Id: header.php,v 1.2 2005/01/31 09:32:24 hunter Exp $ -->
