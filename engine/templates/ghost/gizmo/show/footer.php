<!-- $Id: footer.php,v 1.1 2005/05/11 07:38:28 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
         <div class="topictime"><?= $session->gizmo['date']." ".$i18n->at." "; ?> <?= (!empty($session->gizmo['time']))?$session->gizmo['time']:"00:00:00"; ?><?= ($session->gizmo['unix_time'] <> $session->gizmo['unix_utime'])?" / ".$session->gizmo['udate']." ".$i18n->at." ".$session->gizmo['utime']:""; ?><?= ($config->authors_sign)?", ":""; ?><? if ($config->authors_sign): ?><?= $i18n->postedby; ?> <a href="mailto:<?= $session->utils->hideEMail($session->gizmo['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->gizmo['author_name']; ?></a><? endif; ?></div>
         </td>
        </tr>
<!-- eof $Id: footer.php,v 1.1 2005/05/11 07:38:28 hunter Exp $ -->
