<?php
        print "<tr><td id=\"header\" class=\"b-border\" colspan=\"4\"><span class=\"parthead\"><a onClick=\"hideIt('security01');  \">".$i18n->security."</a></span></td></tr>\n";
	print "<tr id=\"security01\"><td width=\"10%\" align=\"right\"><strong>код: </strong></td>";
	print "<td width=\"60%\" align=\"center\"><input style=\"width: 100%\" type=\"text\" name=\"secretkey\" value=\"\" /></td>";
	print "<td width=\"30%\" align=\"center\" colspan=\"2\"><div style=\" text-align : center; position : relative; \"><img border=\"1\" src=\"".$config->cache_data_path."/secrets/".md5($session->secret_key).".png\" /></div></td>";
	print "</tr><tr><td id=\"header\" class=\"t-border\" colspan=\"4\"><input type=\"hidden\" name=\"secretkey_md5\" value=\"".md5($session->secret_key)."\" /></td></tr>";
?>
