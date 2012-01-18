        <tr>
         <td width="99%" id="text" class="h-border" align="left" valign="top" <? if ((!$config->show_categories) || (!$config->use_categories) || (!file_exists("images/signs/".$session->blog['category'].".png"))): ?>colspan="2"<? endif; ?>>
	   <div class="topictext"><?= chop(stripslashes($session->blog['text'])); ?></div>
         </td>
	 <? if (($config->show_categories) && ($config->use_categories) && (file_exists("images/signs/".$session->blog['category'].".png"))): ?>
          <td width="10%" align="center" valign="middle">
	   <a href="<?= $session->utils->makeHRURL("?module=".$session->module."&category=".$session->blog['category']); ?>"><img src="images/signs/<?= $session->blog['category']; ?>.png" border="0"></a><br />
          </td>
	 <? endif; ?>
        </tr>
