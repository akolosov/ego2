<!-- $Id: a_auth.php,v 1.4 2005/04/26 07:09:41 hunter Exp $ -->
<? if ($config->authorization_is_allowed): ?>
    <tr>
     <td width="100%" align="center" valign="center" colspan="3">&nbsp;</td>
    </tr>  
  <? if (is_null($session->user['name']) || is_null($session->user['mail']) || is_null($session->user['passwd'])): ?>
    <tr>
     <td width="100%" class="border"  align="center" valign="center" colspan="2">
      <span><strong><br />Введите свое имя, адрес эл.почты и ваш пароль чтобы получить доступ к другим разделам сайта.<br />Вся информация будет запомнена и при следующем входе (если у Вас работают cookie) авторизация пройдет автоматически.<br />Автор проекта гарантирует сохранность Ваших конфедициальных данных.<br /><br /></strong></span>
       <nobr><form align="center" action="<?= $session->utils->makeHRURL("?module=auth"); ?>" method="POST">&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $i18n->name; ?>:</strong>&nbsp;&nbsp;<input type="text" name="name" value="<?= $session->user['name']; ?>" size="15" />&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $i18n->email; ?>:</strong>&nbsp;&nbsp;<input type="text" name="email" value="<?= $session->user['mail']; ?>" size="30" />&nbsp;&nbsp;&nbsp;&nbsp;<strong><?= $i18n->lang; ?>:</strong>&nbsp;&nbsp;<select name="language"><?= "<option value=\"".$config->default_language."\" />".$config->default_language."\n<option value=\"en\" />en</select>&nbsp;&nbsp;"; ?><strong><?= $i18n->password; ?>:</strong>&nbsp;&nbsp;<input type="password" name="passwd" value="" size="15" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value=" <?= $i18n->login; ?> " /></form></nobr>
     </td>
    </tr>
  <? else: ?>
    <tr>
     <td width="100%" class="border"  align="right" valign="center" colspan="2">
      <span class="topic"><strong><nobr>&nbsp;&nbsp;<?= $session->user['name']; ?>&nbsp;&nbsp;<?= ($session->user['isadmin']?"(admin)&nbsp;&nbsp;":"&nbsp;&nbsp;"); ?><input type="submit" name="submit" onClick="document.location.href = '<?= $session->utils->makeHRURL("?module=unauth"); ?>';" value=" <?= $i18n->logout; ?> " /></nobr></strong></span>
     </td>
    </tr>
  <? endif; ?>    
<? endif; ?>
<!-- eof $Id: a_auth.php,v 1.4 2005/04/26 07:09:41 hunter Exp $ -->
