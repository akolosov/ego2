         <div width="99%" id="text" <?= ($session->module == "comments")?" class=\"border\" ".$session->body_style:" class=\"h-border\""; ?> align="left" valign="top">
	   <div class="topictext"><?= chop(stripslashes($session->blog['text'])); ?></div>
	   <div class="topictime"><?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a><? endif; ?></div>
         </div>
	 <? if (($config->show_categories) && ($config->use_categories) && (file_exists("images/signs/".$session->blog['category'].".png"))): ?>
          <div width="10%" align="center" valign="middle">
	   <a href="<?= $session->utils->makeHRURL("?module=blog&category=$session->blog['category']"); ?>"><img src="images/signs/<?= $session->blog['category']; ?>.png" border="0"></a><br />
          </div>
	 <? endif; ?>
        </tr>
