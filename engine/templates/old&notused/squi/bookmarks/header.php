<?php
        print "<td ".$session->header_style." class=\"border\" align=\"left\" valign=\"middle\" colspan=\"2\" id=\"header\">\n";
        print "  <span class=\"topichead\">..:: ".$i18n->site_modules[$session->module]." | ".$i18n->site_actions[$session->action]." | ".(!empty($config->language[$user])?$config->language[$user]:"пользователь : ".$user)." </span>\n";
        print " </td>\n";
        print "</tr>\n";

	print "<tr ".$session->body_style.">\n";
	print " <td class=\"v-border\" align=\"left\" valign=\"top\" colspan=\"2\">\n";
	print "  <table width=\"100%\">\n";

?>