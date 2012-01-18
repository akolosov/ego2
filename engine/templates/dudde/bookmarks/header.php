<?php
        print "<td class=\"b-border\" align=\"left\" valign=\"middle\" colspan=\"2\" id=\"header\">\n";
        print "  <span class=\"parthead\">".$i18n->site_modules[$session->module]." | ".$i18n->site_actions[$session->action]." | ".(!empty($config->language[$user])?$config->language[$user]:"пользователь : ".$user)." </span>\n";
        print " </td>\n";
        print "</tr>\n";
	print "<tr>\n";
	print " <td align=\"left\" valign=\"top\" colspan=\"2\">\n";
	print "  <table width=\"100%\">\n";
?>