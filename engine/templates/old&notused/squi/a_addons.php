<!-- $Id: a_addons.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
     <td align="center" valign="top" width="20%">
      <table align="right" valign="top" border="0" cellspacing="0" cellpadding="0" width="100%">
       <tbody>
	<tr>
	 <td>&nbsp;</td>
	</tr>
	<tr>
	 <td class="border" id="addons" <?= $session->footer_style;?> align="right" valign="middle"><span class="parthead">..:: <?= $i18n->addons; ?> </span></td>
	</tr>
	<tr>
	 <td>&nbsp;</td>
	</tr>
<?php
	foreach ($config->in_addons_sidebar as $addon) {
		if (in_array($addon, get_class_methods(get_class($this)))) {
			$this->$addon();
		}
	}
?>
       </tbody>
      </table>
     </td>
<!-- eof $Id: a_addons.php,v 1.1 2005/01/21 08:16:57 hunter Exp $ -->
