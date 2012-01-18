<?php
  if (file_exists($config->styles_modules_path."/".$session->style."/a_config.php")) {
       require($config->styles_modules_path."/".$session->style."/a_config.php");
  }
?>
 <body <?= $session->main_style; ?> background="">
  <table align="<?= $config->default_align; ?>" border="0" cellspacing="0" cellpadding="0" width="<?= $config->default_width; ?>">
   <tbody>
<?php
   require($config->styles_modules_path."/".$session->style."/a_title.php");
   require($config->styles_modules_path."/".$session->style."/a_navigation.php");
   require($config->styles_modules_path."/".$session->style."/a_auth.php");

   if ((in_array($session->module, array_keys($config->addons_by_modules))) && (!in_array($session->sub, $config->no_addons_in_subactions)) && (!in_array($session->action, $config->no_addons_in_actions))) {
     print "<tr>";
     print " <td width=\"100%\" align=\"left\" valign=\"top\" colspan=\"2\">";
     print "  <table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"99%\">";
     print "   <tbody>";
   }

   print "<tr>\n";
   print "<td width=\"100%\" height=\"100%\" align=\"left\" valign=\"top\" colspan=\"3\">\n";
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
 </body>