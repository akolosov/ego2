<!-- $Id: footer.php,v 1.2 2005/02/01 11:53:57 hunter Exp $ -->
       <?php
            if (!empty($session->blog['addons'])) {
              print "<tr>\n";
              print "<td width=\"15%\" class=\"t-border\" id=\"footer\" align=\"left\" valign=\"middle\">\n";
              print "<span class=\"parthead\"><strong>".$i18n->seealso."&nbsp;</strong>\n";
              print "</span>\n</td>\n";
              print "<td class=\"t-border\" width=\"85%\" id=\"footer\" align=\"left\" valign=\"middle\">\n";
              print "<span class=\"topiclinx\">:&nbsp;";
              foreach((split(";", $session->blog['addons'])) as $session->blog['addon_tmp']) {
                $session->blog['addon'] = split(",", $session->blog['addon_tmp']);
                if (!empty($session->blog['addon'][1])) {
                  print "<a href=".$session->blog['addon'][1]." target=\"_blank\">[".$session->blog['addon'][0]."]</a>&nbsp;&nbsp;";
                }
              }
              print "</span>";
              print "</td>\n</tr>\n";
            }
         ?>
        <tr>
         <td width="15%" class="t-border" id="footer" align="left" valign="middle">
          <span class="parthead">
          <strong><?= $i18n->actions; ?></strong>
          </span>
         </td>	 
         <td width="85%" class="t-border" id="footer" align="left" valign="middle">
	  <span class="topiclinx">&nbsp;:
	  <a href="javascript:quoteIt('<?= $session->comment['quoted']; ?>', '<?= $author_name; ?>', '<?= $author_email; ?>'); ">[<?= $i18n->cite; ?>]</a>&nbsp;
          <? if ((($session->security->canUser($session->module, $config->right_to_bookmark) == 1) || ($session->user['isadmin'])) && ($config->use_bookmarks)): ?><a href="<?= $session->utils->makeHRURL("?module=".$session->module."&action=bookmarks&sub=append&board=".$session->board."&tid=".$session->tid); ?>">[<?= $i18n->tobookmarks; ?>]</a><? endif; ?></span>
         </td>
       </tr>
<!-- eof $Id: footer.php,v 1.2 2005/02/01 11:53:57 hunter Exp $ -->
