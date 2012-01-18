        <tr>
         <td  width="99%" id="text" align="left" valign="top" <? if ((!$config->show_categories) || (!$config->use_categories) || (!file_exists("images/signs/".$session->blog['category'].".png"))): ?>colspan="2"<? endif; ?>>
	   <span class="topictext"><?= chop(stripslashes($session->blog['text'])); ?><br /><br />
	   <span class="topictime"><?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a><? endif; ?></span></span>
         </td>
	 <? if (($config->show_categories) && ($config->use_categories) && (file_exists("images/signs/".$session->blog['category'].".png"))): ?>
          <td width="10%" align="center" valign="middle">
	   <a href="<?= $session->utils->makeHRURL("?module=blog&category=".$session->blog['category']); ?>"><img src="images/signs/<?= $session->blog['category']; ?>.png" border="0"></a><br />
          </td>
	 <? endif; ?>
        </tr>
