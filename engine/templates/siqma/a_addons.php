<!-- $Id: a_addons.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
     <td align="left" valign="top" width="20%">
      <table id="addonstable" align="left" valign="top" border="0" cellspacing="0" cellpadding="0" width="100%">
       <tbody>
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
<!-- eof $Id: a_addons.php,v 1.1 2005/01/21 08:16:56 hunter Exp $ -->
