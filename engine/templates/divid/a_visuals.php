<!-- $Id: a_auth.php,v 1.2 2005/01/31 09:32:13 hunter Exp $ -->
    <div class="parthead"><a onClick="hideIt('visuals'); " style=" cursor: pointer; "><?= $i18n->addons; ?></a></div>
    <div class="h-border" id="visuals" style=" display: <?= $_COOKIE['visuals']; ?>; ">
    <nobr><div><?= $i18n->lang; ?>:</div><div class="maintance"><a href="<?= $session->utils->makeHRURL("?language=ru"); ?>">[ru]</a>&nbsp;&nbsp;<a href="<?= $session->utils->makeHRURL("?language=en"); ?>">[en]</a></div></nobr><br />
<? if ($config->use_visual_styles): ?>    
      <nobr><div><?= $i18n->style; ?>:</div><div><select name="style" value="?style=<?= $session->style; ?>" onChange="if (this.value) { document.location.href = this.value; }">
                <option value="" />
                <?= get_styles_list(true); ?>
             </select>
    </div></nobr><br />
<? endif; ?>    
<? if ($config->use_visual_themes): ?>    
    <nobr><div><?= $i18n->theme; ?>:</div><div><select name="theme" value="?theme=<?= $session->theme; ?>" onChange="if (this.value) { document.location.href = this.value; }">
                <option value="" />
                <?= get_themes_list(true); ?>
             </select>
     </div></nobr>
<? endif; ?>
    </div>  
    <br />
<!-- eof $Id: a_auth.php,v 1.2 2005/01/31 09:32:13 hunter Exp $ -->
