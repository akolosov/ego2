<?php
        print "<td ".$session->header_style." class=\"border\" align=\"left\" valign=\"middle\" colspan=\"2\" id=\"header\">\n";
        print "  <span class=\"topichead\">..:: ".$i18n->site_modules[$module]." | ".$i18n->site_actions[$session->action]." </span>\n";
        print " </td>\n";
        print "</tr>\n";

	print "<tr ".$session->body_style.">\n";
	print " <td class=\"v-border\" align=\"left\" valign=\"top\" colspan=\"2\">\n";
	print "  <table width=\"100%\">\n";
	print "   <tr>\n";
	print "    <td class=\"r-border\" align=\"left\" valign=\"top\" id=\"text\" width=\"50%\">\n";
?>