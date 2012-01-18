<?php
  if (file_exists($config->styles_modules_path."/".$session->style."/a_config.php")) {
       require($config->styles_modules_path."/".$session->style."/a_config.php");
  }
?>
 <body bgcolor="#FFFFFF" background="/images/bg_<?= $session->style; ?>.gif"><br />
  <div id="container">
<?php
   require($config->styles_modules_path."/".$session->style."/a_navigation.php");
   require($config->styles_modules_path."/".$session->style."/a_title.php");

   if ((in_array($session->module, array_keys($config->addons_by_modules))) && (!in_array($session->sub, $config->no_addons_in_subactions)) && (!in_array($session->action, $config->no_addons_in_actions))) {
     $this->_addons->showContent();
   }

   print "<div id=\"content\">";
   $this->_module->showContent();
   print "</div>";
   require($config->styles_modules_path."/".$session->style."/a_copyleft.php");
?>
  </div>
  <br />
 </body>