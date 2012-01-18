<!-- $Id: header.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->

        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
       </tr>
        <tr>
         <td class="b-border" id="header" align="left" valign="middle" colspan="2">
          <span class="topictime"><?= $session->comment['date']." ".$i18n->at." "; ?><?= (!empty($session->comment['time']))?$session->comment['time']:"00:00:00"; ?></span><a name=<?= $session->comment['id']; ?>></a><span class="topichead">&nbsp;&nbsp;//&nbsp;&nbsp;<?= $session->comment['title']; ?>&nbsp;&nbsp;//&nbsp;&nbsp;</span><span class="topicauth"><?= $i18n->postedby; ?>&nbsp;<a href="mailto:<?= $session->utils->hideEMail($session->comment['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->comment['author_name']; ?></a></span>
         </td>
       </tr>
<!-- eof $Id: header.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
