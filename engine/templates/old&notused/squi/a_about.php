<!-- $Id: a_about.php,v 1.2 2005/02/10 06:09:42 hunter Exp $ -->
  <tr>
    <td width="100%" align="left" valign="middle" colspan="2">
     &nbsp;
    </td>
  </tr>
<? if (file_exists($config->about_modules_path."/about_me.php")): ?>
  <tr>
    <td <?= $session->header_style; ?> id="header" class="border" width="100%" align="left" valign="middle" colspan="2">
     <span class="topichead"> ..:: <?= $i18n->aboutme; ?> </span>
    </td>
  </tr>
  <tr>
    <td <?= $session->body_style; ?> id="text"class="rbl-border" width="100%" align="left" valign="middle" colspan="2">
    <?php require($config->about_modules_path."/about_me.php"); ?>  
    </td>
  </tr>
  <tr <?= $session->footer_style; ?> >
   <td class="rbl-border" width="80%" id="footer" align="left" valign="middle" colspan="2">
    <span class="topiclinx"><a href="http://www.ebb.org/ungeek/">[<?= $i18n->decrypt; ?>]</a> <a href="http://www.geekcode.com/geek.html">[<?= $i18n->description; ?>]</a> <a href="files/alexey.asc">[<?= $i18n->pgpkey; ?>]</a></span>
   </td>
  </tr>
<? endif; ?>
<? if (file_exists($config->about_modules_path."/".$session->language."/".$config->default_locale_short."/about_ngine.php")): ?>
  <tr>
    <td width="100%" align="left" valign="middle" colspan="2">
     &nbsp;
    </td>
  </tr>
  <tr>
    <td <?= $session->header_style; ?> id="header" class="border" width="100%" align="left" valign="middle" colspan="2">
     <span class="topichead"> ..:: <?= $i18n->aboutengine; ?> </span>
    </td>
  </tr>
  <tr>
    <td <?= $session->body_style; ?> id="text" class="rbl-border" width="100%" align="left" valign="middle" colspan="2">
    <?php require($config->about_modules_path."/".$session->language."/".$config->default_locale_short."/about_ngine.php"); ?>
    </td>
  </tr>
  <tr <?= $session->footer_style; ?> >
   <td class="rbl-border" width="80%" id="footer" align="left" valign="middle" colspan="2">
    <span class="topiclinx"><a href="/files/engine/">[<?= $i18n->download; ?>]</a></span>
   </td>
  </tr>
<? endif; ?>