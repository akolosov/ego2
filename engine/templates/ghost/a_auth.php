<!-- $Id: a_auth.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
<? if ($config->authorization_is_allowed): ?>
    <tr>
     <td  class="title" width="100%" align="left" valign="center" colspan="3" id="header"><span class="parthead"><a onClick="hideIt('auth01'); " style=" cursor: pointer; "><?= $i18n->auth; ?></a></span></td>
    </tr>
  <? if (is_null($session->user['name']) || is_null($session->user['mail']) || is_null($session->user['passwd'])): ?>
    <tr id="auth01" style=" display: <?= $_COOKIE['auth01']; ?>; ">
     <td width="100%" align="center" valign="center" colspan="3"><br />
      <div id="authhelp" style=" display: none; border: 1px dashed #666666; background: #eeeeee; position : float; "><span class="topic" align="center"><br />Введите свое имя, адрес эл.почты и ваш пароль чтобы получить доступ к другим разделам сайта. Вся информация будет запомнена и при следующем входе (если у Вас работают cookie) авторизация пройдет автоматически. Автор проекта гарантирует сохранность Ваших конфедициальных данных.<br /><br /></span></div>
       <nobr class="topic"><form align="right" action="<?= $session->utils->makeHRURL("?module=auth"); ?>" method="<?= $config->default_method; ?>"><table><tr><td align="right"><?= $i18n->name; ?>:</td><td align="left"><input type="text" name="name" value="<?= $session->user['name']; ?>" size="15" /></td></tr><tr><td align="right"><?= $i18n->email; ?>:</td><td align="left"><input type="text" name="email" value="<?= $session->user['mail']; ?>" size="20" /></td><tr><td align="right"><?= $i18n->lang; ?>:</td><td align="left"><select name="language"><?= "<option value=\"".$config->default_language."\" />".$config->default_language."\n<option value=\"en\" />en</select>"; ?></td></tr><tr><td align="right"><?= $i18n->password; ?>:</td><td align="left"><input type="password" name="passwd" value="" size="15" /></td></tr><tr><td>&nbsp;</td><td align="left"><input type="submit" name="submit" value=" <?= $i18n->login; ?> " /><a onClick="hideIt('authhelp'); " style=" cursor : help; ">[ ? ]</a></td></tr></table></form></nobr>
     </td>
    </tr>
  <? else: ?>
    <tr id="auth01" style=" display: <?= $_COOKIE['auth01']; ?>; ">
     <td width="100%" align="right" valign="center" colspan="3"><br />
      <span class="topic"><nobr><?= $session->user['name']; ?>&nbsp;&nbsp;<?= ($session->user['isadmin']?"(admin)&nbsp;&nbsp;":"&nbsp;&nbsp;"); ?><input type="submit" name="submit" onClick="document.location.href = '<?= $session->utils->makeHRURL("?module=unauth"); ?>';" value=" <?= $i18n->logout; ?> " /></nobr></span><br /><br />
     </td>
    </tr>
  <? endif; ?>    
    <tr>
     <td class="t-border" width="100%" align="right" valign="center" colspan="3">&nbsp;</td>
    </tr>
<? endif; ?>
<!-- eof $Id: a_auth.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
