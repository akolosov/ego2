<!-- $Id: a_addons.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
     <td  <?= $session->body_style; ?> class="border" align="center" valign="top" width="30%">
      <table id="addontable" align="right" valign="top" border="0" cellspacing="0" cellpadding="0" width="100%">
       <td>
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
	<tr>
	 <td class="title" id="header" align="left" id="header"><span class="parthead"><a onClick=" hideIt('links01'); hideIt('links02'); " style=" cursor : pointer; "><?= $i18n->banners; ?></a></span></td>
	</tr>
	<tr id="links01" style=" display : <?= $_COOKIE['links01']; ?>; ">
	 <td class="b-border" id="text" align="center">
      <nobr><a href="<?= $config->ngine_url; ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="/images/ego.png" border="0" title="powered by <?= $config->ngine_name; ?>" /></a><? if ($config->use_awstats): ?>&nbsp;<a href="<?= $config->awstats_url; ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="/images/awstats.png" /></a><? endif; ?>&nbsp;<a href="http://del.icio.us/mr.hunter/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/delicious.png" border="0" title="Use del.icio.us!" /></a></nobr><br /><nobr>
<? if (true): ?>
	<a href="http://blogs.f-y.ru/in.php?site=1119511725" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/100.png" title="ТОП 100 Русских Блоггеров" border=0></a>&nbsp;<a href="http://catalog.wmas.msk.ru/from.php?13" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/wmas.png" title="WMasКАТАЛОГ - интернет каталог блогов" border="0" /></a>&nbsp;<a href="http://theweblog.net/top/in.php?id=13" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="http://theweblog.net/top/button.php?id=13" border="0"></a></nobr><br />
<? endif; ?>
<nobr><? if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))): ?><? if ($config->ngine_validities['rss20']): ?><a href="http://feedvalidator.org/check.cgi?url=<?= $config->site_url.$session->utils->makeHRURL($session->module."&action=rss20"); ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/rss-valid.png" border="0" title="RSS 2.0 Valid" /></a>&nbsp;<? endif; ?><a href="<?= $session->utils->makeHRURL($session->module."&action=rss20"); ?>"><img src="images/rss2.gif" border="0" title="RSS 2.0 feed" /></a><? endif; ?>&nbsp;<a href="http://www.livejournal.com/users/hunter_rss/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/lj-syndicated.png" border="0" title="syndicated by LiveJournal" /></a></nobr><br />
<nobr><? if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))): ?><? if ($config->ngine_validities['atom03']): ?><a href="http://feedvalidator.org/check.cgi?url=<?= $config->site_url.$session->utils->makeHRURL($session->module."&action=atom03"); ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/atom-valid.png" border="0" title="ATOM 0.3 Valid" /></a>&nbsp;<? endif; ?><a href="<?= $session->utils->makeHRURL($session->module."&action=atom03"); ?>"><img src="images/atom-03.png" border="0" title="ATOM 0.3 feed" /></a>&nbsp;<? endif; ?>
<? if (($config->export_to_opml) && (file_exists($config->opml_data_path))): ?>
<a href="<?= $config->site_url.$config->opml_data_path; ?>"><img src="/images/opml.png" /></a><? endif; ?></nobr><br />
<nobr><? if ($config->ngine_validities['css20']): ?><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/css-valid.png" border="0" title="CSS 2.0 Valid" /></a>&nbsp;<? endif; ?><? if ($config->ngine_validities['xhtml4x']): ?><a href="http://validator.w3.org/check/referer" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/xhtml-valid.png" border="0" title="xHTML 4.x Valid" /></a>&nbsp;<? endif; ?></nobr>
	 </td>
	</tr>
	<tr id="links02" style=" display : <?= $_COOKIE['links02']; ?>; ">
	 <td class="b-border" id="text" align="center">
	  <nobr><a href="http://www.gravatar.com/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/gravatar.png" border="0" title="Use GRAvatar!" /></a>&nbsp;<a href="http://www.bloglines.com/sub/http://ego.b0b.org/blog" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/bloglines.png" border="0" title="syndicate with BlogLines.Com" /></a>&nbsp;<a href="http://feeds.feedburner.com/egoist" title="Subscribe to my feed with FeedBurner.Com"><img src="images/feedburner.png" /></a></nobr><br />
	 </td>
	</tr>
	<tr>
	 <td id="addons" align="left">&nbsp;</td>
	</tr>
	<tr <?= ($config->use_adsense)?"":"style=\" display : none; \""; ?>>
	 <td class="title" id="header" align="left" id="header"><span class="parthead"><a onClick=" hideIt('advert01'); hideIt('advert02'); " style=" cursor : pointer; "><?= $i18n->advert; ?></a></span></td>
	</tr>
	<tr id="advert01" style=" display : <?= ($config->use_adsense)?$_COOKIE['advert01']:"none"; ?>; " >
	 <td class="b-border" id="text" align="center">
	  <div align="center" width="100%">
	   <script type="text/javascript">
<!--
		google_ad_client = "pub-1904067305139202";
		google_ad_channel ="2620709165";
		google_ad_width = 160;
		google_ad_height = 600;
		google_ad_format = "160x600_as";
		google_ad_type = "text_image";
		google_color_border = "CCCCCC";
		google_color_bg = "FFFFFF";
		google_color_link = "000000";
		google_color_url = "666666";
		google_color_text = "333333";
		google_language = "ru";
//-->
	   </script>
	   <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	  </div>
	 </td>
	</tr>
	<tr id="advert02" style=" display : <?= ($config->use_adsense)?$_COOKIE['advert02']:"none"; ?>; ">
	 <td class="b-border" id="text" align="center">
	  <div align="center" width="100%">
	   <script type="text/javascript">
<!--
		google_ad_client = "pub-1904067305139202";
		google_ad_width = 200;
		google_ad_height = 90;
		google_ad_format = "200x90_0ads_al_s";
		google_ad_channel ="2620709165";
		google_ad_type = "text";
		google_color_border = "CCCCCC";
		google_color_bg = "FFFFFF";
		google_color_link = "000000";
		google_color_url = "666666";
		google_color_text = "333333";
		google_language = "ru";
//-->
	   </script>
	   <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	  </div>
	 </td>
	</tr>
	<tr <?= ($config->use_adsense)?"":"style=\" display : none; \""; ?>>
	 <td id="footer" align="left">&nbsp;</td>
	</tr>
       </tbody>
      </table>
     </td>
<!-- eof $Id: a_addons.php,v 1.1 2005/05/11 07:38:21 hunter Exp $ -->
