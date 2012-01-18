<!-- $Id: footer.php,v 1.1 2005/05/11 07:38:43 hunter Exp $ -->
        <tr>
         <td width="100%" id="footer" align="left" valign="middle" colspan="2">
         <div class="topictime"><?= $session->comment['date']." ".$i18n->at." "; ?><?= (!empty($session->comment['time']))?$session->comment['time']:"00:00:00"; ?>, <?= $i18n->postedby; ?>&nbsp;<a href="mailto:<?= $session->utils->hideEMail($session->comment['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->comment['author_name']; ?></a></div>
         </td>	
       </tr>
<!-- eof $Id: footer.php,v 1.1 2005/05/11 07:38:43 hunter Exp $ -->
