<!-- $Id: text.php,v 1.4 2005/02/10 06:09:42 hunter Exp $ -->
  <script language="JavaScript">
<!--  
    		document.onLoad = "document.topic.focus();";
-->	
  </script>
        <tr>
         <td class="border" width="100%" align="center" valign="top" colspan="2">
	  <? if(!is_null($session->post_err)): ?>
	    <font color=red><b><?= $session->post_err; ?></b></font>
	  <? endif; ?>
 	  <br /><form name="post" action="<?= $session->utils->makeHRURL("?module=comments&action=show&sub=add&id=".sizeof($comments)."&tid=".$session->tid."&board=".$session->board); ?>" method="POST">
	   <table width="95%" align="center" valign="top">
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('header01'); hideIt('header02'); "><?= $i18n->header; ?></a></span></td></tr>
	    <tr id="header01">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->name; ?>:</strong></td>
	     <td width="40%"><input type="text" name="name" style="width: 100%" value="<?=(!is_null($session->post_err))?$_POST['name']:$session->user['name']; ?>"></td>
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->email; ?>:</strong></td>
	     <td width="40%"><input type="text" name="email" style="width: 100%" value="<?=(!is_null($session->post_err))?$_POST['email']:((!is_null($session->user['mail']))?$session->user['mail']:$config->phantom_email); ?>"></td>
	    </tr>
	    <tr id="header02">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->subject; ?>:</strong></td>
	     <td width="90%" colspan="3"><input type="text" style="width: 100%" name="topic" value="<?=(!is_null($session->post_err))?$_POST['topic']:$all_title; ?>"></td>
	    </tr>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('text01'); hideIt('text02'); hideIt('text03'); "><?= $i18n->text; ?></a></span></td></tr>
<?php
            require($config->modules_path."/addons/".$session->language."/".$config->default_locale_short."/WackoWiki-tags.php");
?>
    	    <tr id="text02">
	     <td width="10%" align="right" valign="top"><strong><?= $i18n->text; ?>:</strong></td>
             <td width="90%" colspan="3"><textarea rows="25" style="width: 100%" name="text"><?=(!is_null($session->post_err))?$_POST['text']:(($config->auto_quote_in_comments)?"<[**".($config->mailto_in_quoted_comments?"[[mailto:".$author_email." ":" ").$author_name.($config->mailto_in_quoted_comments?"]]":"")."**: ".$session->comment['quoted']."]>":""); ?></textarea></td>
	    </tr>
<?php
            require($config->modules_path."/addons/".$session->language."/".$config->default_locale_short."/about-WackoWiki-tags.php");
?>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	    <tr><td id="header" class="b-border" colspan="4"><span class="maintance"><a onClick="hideIt('control01'); hideIt('control02'); "><?= $i18n->controls; ?></a></span></td></tr>
	    <tr id="control01">
	     <td width="100%" align="center" valign="top" colspan="4" align="center"><input type="checkbox" id="subscribe" name="subscribe" <?php ($session->user['mail']==$author_email)?"":"checked"; ?>><strong><label for="subscribe"><?= $i18n->subscribe; ?></label></strong></td>
	    </tr>
	    <tr id="control02">
	     <td width="10%" align="right" valign="top"> </td>
	     <td width="90%" align="center" valign="top" colspan="3" align="center"><input type="submit" name="submit" style="width: 100%" value="<?= $i18n->submit; ?>"></td>
	    </tr>
	    <tr><td id="header" class="t-border" colspan="4">&nbsp;</td></tr>
	   </table>
	  </form>
         </td>
        </tr>
<!-- eof $Id: text.php,v 1.4 2005/02/10 06:09:42 hunter Exp $ -->
