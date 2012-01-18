<!-- $Id: text.php,v 1.1 2005/05/11 07:37:33 hunter Exp $ -->
        <tr>
         <td class="border" align="center" valign="top" colspan="2">
	  <br />
	  <? if(!is_null($session->post_err)): ?>
	   <font color=red><strong><?= $session->post_err; ?></strong></font>
	  <? endif; ?>
 	  <form name="post" action="<?= $session->utils->makeHRURL("?module=blog&action=show&sub=append"); ?>" method="<?= $config->default_method; ?>">
	   <table width="90%" align="center" valign="top">
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('header01'); hideIt('header02'); "><?= $i18n->header; ?></a></span></td></tr>
	    <tr id="header01">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->name; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%" type="text" name="name" value="<?= $session->user['name']; ?>"></td>
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->email; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%"type="text" name="email" value="<?= $session->user['mail']; ?>"></td>
	    </tr>
	    <tr id="header02">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->subject; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%"type="text" name="topic" value="<?= $session->data['topic']; ?>"></td>
	      
	     <td width="10%" align="right" valign="top"><strong><?php if ($config->use_categories) { print $i18n->category.":"; } ?></strong></td>
	     <td width="40%">
	      <? if ($config->use_categories): ?>
	       <select name="category" style="width: 100%" value="<?= $session->data['category']; ?>"><?= $session->utils->getCategoriesList(true); ?></select>
	      <? endif; ?>
	     </td>
	    </tr>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('text01'); hideIt('text02'); hideIt('text03'); "><?= $i18n->text; ?></a></span></td></tr>
<?php
	    if ($config->use_wackoformatter) {
              require($config->modules_path."/addons/".$session->language."/".$config->default_locale_short."/WackoWiki-tags.php");
	    }
?>
	    <tr id="text02">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->text; ?>:</strong></td>
	     <td colspan="3" width="80%"><textarea rows="25" style="width: 100%" name="text"><?= $session->data['text']; ?></textarea></td>
	    </tr>
<?php
	    if ($config->use_wackoformatter) {
              require($config->modules_path."/addons/".$session->language."/".$config->default_locale_short."/about-WackoWiki-tags.php");
	    }
?>
	<tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	<? if ($config->use_url_forms): ?>
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('urls01'); hideIt('urls02'); "><?= $i18n->addons; ?></a></span></td></tr>
	    <tr id="urls01" style="display: none; ">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->url; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%" type="text" name="url1" value="<?= $session->data['url1']; ?>"></td>
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->description; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%" type="text" name="url_name1" value="<?= $session->data['url_name1']; ?>"></td>
	    </tr>
	    <tr id="urls02" style="display: none;">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->url; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%" type="text" name="url2" value="<?= $session->data['url2']; ?>"></td>
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->description; ?>:</strong></td>
	     <td width="40%"><input style="width: 100%" type="text" name="url_name2" value="<?= $session->data['url_name2']; ?>"></td>
	    </tr>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	<? endif; ?>
	<? if ($config->use_keywords): ?>
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('keys01'); hideIt('keys02'); "><?= $i18n->keys; ?></a></span></td></tr>
    	    <tr id="keys01">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->keys; ?>:</strong></td>
	     <td width="60%"><textarea rows="5" style="width: 100%" name="keys" <? print ((($session->security->canUser($session->module, $config->right_to_keywords) == 1) || ($session->user['isadmin']))?"":"readonly" ); ?>><?= $session->data['keys']; ?></textarea></td>
	     <td width="30%" align="right" valign="top" colspan="2"><select name="keylist" style="width: 98%" value="" multiple size="6" onDblClick='addKey(this.value);' ><?= $session->utils->getKeysList($session->module, true); ?></select></td>
 	    </tr>
    	    <?php require($config->modules_path."/addons/".$session->language."/".$config->default_locale_short."/about-keys.php"); ?>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	<? endif; ?>
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('control01');  "><?= $i18n->controls; ?></a></span></td></tr>
	    <tr id="control01">
	     <td width="10%"> </td>
	     <td width="100%" align="right" colspan="3" align="center"><nobr><input type="submit" name="submit" style="width: 50%" value="<?= $i18n->submit; ?>" />&nbsp;&nbsp;<input type="submit" name="save" style="width: 50%" value="<?= $i18n->savecont; ?>" onClick="document.post.action = '<?= $session->utils->makeHRURL("?module=blog&action=save&sub=changed&id=".$session->id); ?>'; " /></nobr></td>
	    </tr>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	   </table>
	  </form>
         </td>
        </tr>
<!-- eof $Id: text.php,v 1.1 2005/05/11 07:37:33 hunter Exp $ -->
