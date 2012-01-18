<!-- $Id: header.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
        </tr>
        <tr>
         <td id="header" class="b-border" align="left" valign="middle" colspan="2">
	  <span class="topictime"><?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?></span><a name="<?= $session->blog['id']; ?>"></a><span class="topichead">&nbsp;&nbsp;//&nbsp;&nbsp;<?= $session->blog['title']; ?><?= ($config->authors_sign)?"&nbsp;&nbsp;//&nbsp;&nbsp;":""; ?></span><? if ($config->authors_sign): ?><span class="topicauth"><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a></span><? endif; ?>
         </td>
        </tr>
<!-- eof $Id: header.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
