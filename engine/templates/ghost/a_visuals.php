<!-- $Id: a_visuals.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
    <tr>
     <td  class="b-border" width="100%" align="left" valign="center" colspan="3"><span class="parthead"><a onClick="hideIt('visuals01'); " style=" cursor: pointer; "><?= $i18n->addons; ?></a></span></td>
    </tr>
    <tr id="visuals01" style=" display: <?= $_COOKIE['visuals01']; ?>; ">
     <td><table><tr class="topic">
     <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?= $i18n->lang; ?>:</td><td align="left" style=" width='100%'; "><span class="maintance"><a href="<?= $session->utils->makeHRURL("?language=ru"); ?>">[ru]</a></span>&nbsp;&nbsp;<span class="maintance"><a href="<?= $session->utils->makeHRURL("?language=en"); ?>">[en]</a></span></td>
    </tr>
<? if ($config->use_visual_styles): ?>    
      <tr class="topic">
      <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?= $i18n->style; ?>:</td><td align="left" style=" width='100%'; "><select name="style" value="?style=<?= $session->style; ?>" onChange="if (this.value) { document.location.href = this.value; }">
                <option value="" />
                <?= $session->utils->getStylesList(true); ?>
             </select>
    </td></tr>
<? endif; ?>    
<? if ($config->use_visual_themes): ?>    
    <tr class="topic">
     <td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<?= $i18n->theme; ?>:</td><td align="left" style=" width='100%'; "><select name="theme" value="?theme=<?= $session->theme; ?>" onChange="if (this.value) { document.location.href = this.value; }">
                <option value="" />
                <?= $session->utils->getThemesList(true); ?>
             </select>
    </td></tr>
<? endif; ?>
	</table>
     </td>
    </tr>  
    <tr>
     <td class="t-border" width="100%" align="right" valign="center" colspan="3">&nbsp;</td>
    </tr>
<!-- eof $Id: a_visuals.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
