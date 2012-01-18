<? if (($config->use_search) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin'])) && (in_array($session->module, $config->search_in_modules)) ): ?>
     <div class="parthead"><a onClick="hideIt('search'); " style=" cursor: pointer; "><?= $i18n->search; ?></a></div>
     <div class="h-border" id="search" style=" display : <?= $_COOKIE['search']; ?>; ">
      <div>
        <br /><form method="POST" action="<?= $session->module; ?>">
        <nobr><input type="text" size="20" maxlength="255" name="search" maxlength="170" value="<?= $session->search; ?>" style=" width:75%; " title="[<?= $i18n->searchdesc; ?>]"></input>&nbsp;
	<input type="submit" style=" width : 20%; " value="<?= $i18n->search; ?>" title="[<?= $i18n->searchdesc; ?>]" src="images/<?= $session->style; ?>/icon-find.png"></input></nobr></form>
      </div>
      <div class="t-border">
        <form method="get" action="http://www.google.com/custom" target="google_window">
         <a href="http://www.google.com/"><img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" align="left"></img></a><br/>
         <nobr><input type="text" name="q" size="20" maxlength="255" value="" style=" width:75%; " ></input>&nbsp;
         <input type="submit" name="sa" value="<?= $i18n->search; ?>" style=" width : 20%; " ></input></nobr>
	 <input type="hidden" name="client" value="pub-1904067305139202" />
	 <input type="hidden" name="forid" value="1" />
	 <input type="hidden" name="channel" value="0942454134" />
	 <input type="hidden" name="ie" value="UTF-8" />
	 <input type="hidden" name="oe" value="UTF-8" />
	 <input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1;" />
	 <input type="hidden" name="hl" value="ru" />
        </form>
       </div>
      </div>
<? endif; ?>
