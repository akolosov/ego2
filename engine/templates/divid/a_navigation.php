    <div id="menu">
      <ul class="menu">
      <?php
        $count = count($config->ngine_modules);
	$mwidth = 100 - (!is_null($session->key)?30:0) - (!is_null($session->search)?30:0);
	if ($count > 1) {
	    $width = (integer)($mwidth/$count);
    	    foreach ($config->ngine_modules as $module) {
		if ($session->security->canUser($module, $config->right_to_read)) {
		    print "<li class=\"navcell\" ".(($session->module==$module)?" id=\"current\"":"")."><span class=\"maintance\"><a href=\"".$session->utils->makeHRURL("?module=".$module)."\">".$i18n->site_modules[$module]."</a></span></li>";
		}
	    }
	}
      ?>
      </ul>
    </div>
