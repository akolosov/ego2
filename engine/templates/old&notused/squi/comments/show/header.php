<!-- $Id: header.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->

        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
       </tr>
        <tr>
         <td <?= $session->header_style; ?> class="border" id="header" align="left" valign="middle" colspan="2">
          <a name=<?= $session->comment['id']; ?>></a><span class="topichead">..:: <?= $session->comment['title']; ?></span><span class="topictime">// <?= $session->comment['date']." ".$i18n->at." "; ?><?= (!empty($session->comment['time']))?$session->comment['time']:"00:00:00"; ?></span>
         </td>
       </tr>
<!-- eof $Id: header.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
