<!-- $Id: text.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
	<?php make_email_quoted_text($session->comment['text']); ?>
        <tr>
         <td id="text" align="left" class="h-border" valign="top" colspan="2">
	  <span class="topictext"><?= stripslashes($session->comment['text']); ?><br /><br />
	  <span class="topictime"><?= $session->comment['date']." ".$i18n->at." "; ?><?= (!empty($session->comment['time']))?$session->comment['time']:"00:00:00"; ?>, <?= $i18n->postedby; ?>&nbsp;<a href="mailto:<?= $session->utils->hideEMail($session->comment['author_email']); ?>" title="<?= $i18n->email2author; ?>"><?= $session->comment['author_name']; ?></a></span></span>
         </td>
        </tr>
<!-- eof $Id: text.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
