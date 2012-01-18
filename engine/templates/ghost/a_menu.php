<? if (($config->use_menus) && (($session->security->canUser($session->module, $config->right_to_read) || $session->user['isadmin'])) ): ?>
     <tr>
      <td class="title" id="header" align="left" valign="middle" >
       <span class="parthead"><a onClick="hideIt('menu01'); " style=" cursor: pointer; "><?= $i18n->menu; ?></a></span>
      </td>
     </tr>
     <tr id="menu01" style=" display : <?= $_COOKIE['menu01']; ?>; ">
      <td class="b-border" id="addons" align="left" valign="middle">
       <?= $session->utils->getModuleMenu(); ?>
      </td>
     </tr>
     <tr>
      <td id="addons" align="left" valign="middle">&nbsp;</td>
     </tr>
<? endif; ?>
