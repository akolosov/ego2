<!-- $Id: footer.php,v 1.1 2005/05/11 07:38:28 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
         <div class="topictime"><?= $session->blog['date']." ".$i18n->at." "; ?> <?= (!empty($session->blog['time']))?$session->blog['time']:"00:00:00"; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->blog['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->blog['author_name']; ?></a><? endif; ?></div>
         </td>
        </tr>
<!-- eof $Id: footer.php,v 1.1 2005/05/11 07:38:28 hunter Exp $ -->
