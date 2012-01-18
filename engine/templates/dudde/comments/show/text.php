<!-- $Id: text.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
        <tr>
         <td id="text" align="left" valign="top" colspan="2">
	  <span class="topictext"><?= stripslashes($session->comment['text']); ?></span>
	  <br /><span class="topiclinx"><a href="mailto:<?= $session->utils->hideEMail($session->comment['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->comment['author_name']; ?></a></span>
         </td>
        </tr>
<!-- eof $Id: text.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
