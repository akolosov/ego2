<!-- $Id: a_auth.php,v 1.2 2005/01/31 09:32:13 hunter Exp $ -->
<? if ($config->authorization_is_allowed): ?>
     <div><span class="parthead"><a onClick="hideIt('auth01'); " style=" cursor: pointer; "><?= $i18n->auth; ?></a></span></div>
    </tr>
  <? if (is_null($session->user['name']) || is_null($session->user['mail']) || is_null($session->user['passwd'])): ?>
    <div id="auth01" style=" display: <?= $_COOKIE['auth01']; ?>; "><br />
      <div id="authhelp" style=" display: none; border: 1px dashed #666666; background: #eeeeee; position : float; "><span class="topic" align="center"><br />Введите свое имя, адрес эл.почты и ваш пароль чтобы получить доступ к другим разделам сайта. Вся информация будет запомнена и при следующем входе (если у Вас работают cookie) авторизация пройдет автоматически. Автор проекта гарантирует сохранность Ваших конфедициальных данных.<br /><br /></span></div>
       <nobr class="topic"><form align="right" action="<?= $session->utils->makeHRURL("?module=auth"); ?>" method="POST"><table><tr><td align="right"><?= $i18n->name; ?>:</td><td align="left"><input type="text" name="name" value="<?= $session->user['name']; ?>" size="15" /></td></tr><tr><td align="right"><?= $i18n->email; ?>:</td><td align="left"><input type="text" name="email" value="<?= $session->user['mail']; ?>" size="20" /></td><tr><td align="right"><?= $i18n->lang; ?>:</td><td align="left"><select name="language"><?= "<option value=\"".$config->default_language."\" />".$config->default_language."\n<option value=\"en\" />en</select>"; ?></td></tr><tr><td align="right"><?= $i18n->password; ?>:</td><td align="left"><input type="password" name="passwd" value="" size="15" /></td></tr><tr><td>&nbsp;</td><td align="left"><input type="submit" name="submit" value=" <?= $i18n->login; ?> " /><a onClick="hideIt('authhelp'); " style=" cursor : help; ">[ ? ]</a></td></tr></table></form></nobr>
    </div>
  <? else: ?>
    <div id="auth01" style=" display: <?= $_COOKIE['auth01']; ?>; "><br />
      <span class="topic"><nobr><?= $session->user['name']; ?>&nbsp;&nbsp;<?= ($session->user['isadmin']?"(admin)&nbsp;&nbsp;":"&nbsp;&nbsp;"); ?><input type="submit" name="submit" onClick="document.location.href = '<?= $session->utils->makeHRURL("?module=unauth"); ?>';" value=" <?= $i18n->logout; ?> " /></nobr></span><br /><br />
    </div>
  <? endif; ?>    
    <br />
<? endif; ?>
<!-- eof $Id: a_auth.php,v 1.2 2005/01/31 09:32:13 hunter Exp $ -->
