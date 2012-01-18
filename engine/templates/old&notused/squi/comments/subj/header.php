<!-- $Id: header.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
        <tr>
         <td align="left" valign="middle" colspan="2">
          &nbsp;
         </td>
       </tr>
        <tr>
         <td <?= $session->header_style; ?> class="border" align="left" valign="middle" colspan="2" id="header">
          <span class="topichead"><nobr>..:: <?= $i18n->site_modules[$session->module]."|".$i18n->site_actions[$session->action]; ?> </nobr></span>
         </td>
       </tr>
<!-- eof $Id: header.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
