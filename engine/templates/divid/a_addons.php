<!-- $Id: a_addons.php,v 1.2 2005/01/31 09:32:13 hunter Exp $ -->
      <div id="addons">
       <div id="header"><span class="parthead"><a onClick=" hideIt('advert'); " style=" cursor : pointer; "><?= $i18n->advert; ?></a></span></div>
	<div class="h-border"  id="advert" style=" display : <?= $_COOKIE['advert']; ?>; ">
	 <div id="text" align="center">
	  <script type="text/javascript">
<!--
		google_ad_client = "pub-1904067305139202";
		google_ad_width = 234;
		google_ad_height = 60;
		google_ad_format = "234x60_as";
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
	 <div class="t-border" id="text" align="center">
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
	</div>
<?php
	foreach ($config->in_addons_sidebar as $addon) {
		if (in_array($addon, get_class_methods(get_class($this)))) {
			$this->$addon();
		}
	}
?>	 
	<div class="h-border" id="header" align="left"><span class="parthead"><a onClick=" hideIt('links'); " style=" cursor : pointer; "><?= $i18n->banners; ?></a></span></div>
	<div id="links" style=" display : <?= $_COOKIE['links']; ?>; ">
	 <div id="text" align="center">
      <nobr><a href="http://www.debian.org/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="/images/debian.png" border="0" title="powered by Debian GNU/Linux" /></a>&nbsp;<a href="<?= $config->ngine_url; ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="/images/ego.png" border="0" title="powered by <?= $config->ngine_name; ?>" /></a><? if ($config->use_awstats): ?>&nbsp;<a href="<?= $config->awstats_url; ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="/images/awstats.png" /></a><? endif; ?></nobr><br /><nobr><a href="http://www.npj.ru/hunter/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/npj-user.png" border="0" title="NPJ user" /></a>&nbsp;<a href="http://npj.ru/foreign/rss/ego/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/npj-syndicated.png" border="0" title="syndicated by NPJ" /></a></nobr><br />
      <nobr><a href="http://www.gravatar.com/" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/gravatar.png" border="0" title="Use GRAvatar!" /></a>&nbsp;<a href="http://www.bloglines.com/sub/http://ego.b0b.org/blog" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/bloglines.png" border="0" title="syndicate with BlogLines.Com" /></a>&nbsp;<a href="http://feeds.feedburner.com/egoist" title="Subscribe to my feed with FeedBurner.Com"><img src="images/feedburner.png" /></a></nobr><br />
<nobr><? if (($config->export_to_rss) && (in_array($session->module, $config->export_in_modules))): ?><? if ($config->ngine_validities['rss20']): ?><a href="http://feedvalidator.org/check.cgi?url=<?= $config->site_url.$session->utils->makeHRURL($session->module."&action=rss20"); ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/rss-valid.png" border="0" title="RSS 2.0 Valid" /></a>&nbsp;<? endif; ?><a href="<?= $session->utils->makeHRURL($session->module."&action=rss20"); ?>"><img src="images/rss2.gif" border="0" title="RSS 2.0 feed" /></a><? endif; ?></nobr><br />
<nobr><? if (($config->export_to_atom) && (in_array($session->module, $config->export_in_modules))): ?><? if ($config->ngine_validities['atom03']): ?><a href="http://feedvalidator.org/check.cgi?url=<?= $config->site_url.$session->utils->makeHRURL($session->module."&action=atom03"); ?>" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/atom-valid.png" border="0" title="ATOM 0.3 Valid" /></a>&nbsp;<? endif; ?><a href="<?= $session->utils->makeHRURL($session->module."&action=atom03"); ?>"><img src="images/atom-03.png" border="0" title="ATOM 0.3 feed" /></a><? endif; ?>
<? if (($config->export_to_opml) && (file_exists($config->opml_data_path))): ?>
&nbsp;<a href="<?= $config->site_url.$config->opml_data_path; ?>"><img src="/images/opml.png" /></a><? endif; ?></nobr><br />
<nobr><? if ($config->ngine_validities['css20']): ?><a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/css-valid.png" border="0" title="CSS 2.0 Valid" /></a>&nbsp;<? endif; ?><? if ($config->ngine_validities['xhtml4x']): ?><a href="http://validator.w3.org/check/referer" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>><img src="images/xhtml-valid.png" border="0" title="xHTML 4.x Valid" /></a>&nbsp;<? endif; ?></nobr>
	 </div>
	</div>
       </div>
<!-- eof $Id: a_addons.php,v 1.2 2005/01/31 09:32:13 hunter Exp $ -->
