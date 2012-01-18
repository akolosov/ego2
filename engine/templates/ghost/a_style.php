<?php
  if (file_exists($config->styles_modules_path."/".$session->style."/a_config.php")) {
       require($config->styles_modules_path."/".$session->style."/a_config.php");
  }
?>
 <body bgcolor="#F0F0F0" background="/images/bg.gif"><br />
  <table id="maintable" <?= $session->main_style; ?> align="<?= $config->default_align; ?>" border="0" cellspacing="0" cellpadding="3" width="<?= $config->default_width; ?>">
   <tbody>
<?php
   require($config->styles_modules_path."/".$session->style."/a_title.php");
   require($config->styles_modules_path."/".$session->style."/a_navigation.php");

   if ((in_array($session->module, array_keys($config->addons_by_modules))) && (!in_array($session->sub, $config->no_addons_in_subactions)) && (!in_array($session->action, $config->no_addons_in_actions))) {
     print "<tr>";
     print " <td width=\"70%\" align=\"left\" valign=\"top\" colspan=\"2\">";
     print "  <table id=\"infotable\" align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"99%\">";
     print "   <tbody>";
   }

   print "<tr>\n";
   print "<td width=\"70%\" align=\"left\" valign=\"top\" colspan=\"3\">\n";
   print "<table align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
   $this->_module->showContent();
   print "</table>";
   print "</td>";
   print "</tr>";

   if ((in_array($session->module, array_keys($config->addons_by_modules))) && (!in_array($session->sub, $config->no_addons_in_subactions)) && (!in_array($session->action, $config->no_addons_in_actions))) {
     print "  </tbody>";
     print " </table>";
     print "</td>";
     $this->_addons->showContent();
     print "</tr>";
   }

   require($config->styles_modules_path."/".$session->style."/a_footer.php");
   require($config->styles_modules_path."/".$session->style."/a_copyleft.php");
?>
     </tbody>
    </table>
   </tbody>
  </table>
  <br />
  <? if ( ! ( ( in_array($session->module, array_keys($config->addons_by_modules)) ) && ( ! in_array($session->action, $config->no_addons_in_actions) ) ) ): ?>
  <div align="center">
   <script type="text/javascript">
<!--
		google_ad_client = "pub-1904067305139202";
		google_ad_width = 728;
		google_ad_height = 90;
		google_ad_format = "728x90_as";
		google_ad_channel ="2620709165";
		google_color_border = "CCCCCC";
		google_color_bg = "FFFFFF";
		google_color_link = "000000";
		google_color_url = "666666";
		google_color_text = "333333";
		google_ad_type = "text_image";
		google_language = "ru";
//-->
   </script>
   <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </div>
<?  endif; ?>
 </body>