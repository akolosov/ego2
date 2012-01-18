<!-- $Id: footer.php,v 1.2 2005/02/01 11:54:16 hunter Exp $ -->
        <tr <?= $session->footer_style; ?> >
         <td class="rbl-border" id="footer" align="left" valign="middle" colspan="2">
	  <span class="topiclinx">
	  <a href="javascript:quoteIt('<?= $session->comment['quoted']; ?>', '<?= $author_name; ?>', '<?= $author_email; ?>'); ">[<?= $i18n->cite; ?>]</a>&nbsp;
          <? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?>
	   <a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=add&board=".$session->board."&tid=".$session->tid); ?>">[<?= $i18n->2bookmarks; ?>]</a>
	  <? endif; ?>
	  <?php
	  if (!empty($session->blog['addons'])) {
	    print " --- ";
	    foreach((split(";", $session->blog['addons'])) as $session->blog['addon_tmp']) {
	      $session->blog['addon'] = split(",", $session->blog['addon_tmp']);
	      if (!empty($session->blog['addon'][1])) {
	        print "<a href=".$session->blog['addon'][1].">[".$session->blog['addon'][0]."]</a> ";
	      }
	    }
	  }
	  print "</span>";
	  ?>
         </td>
       </tr>
<!-- eof $Id: footer.php,v 1.2 2005/02/01 11:54:16 hunter Exp $ -->
