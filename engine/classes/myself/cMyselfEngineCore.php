<?php

class cMyselfEngineCore extends cEngineCore {

	public $_storagesManager	= NULL;
	public $_sessionsManager	= NULL;
	public $_configsManager		= NULL;
	public $_contentManager		= NULL;
	public $_securityManager	= NULL;
	public $_i18nManager		= NULL;
	public $_coreUtils		= NULL;
	public $_textFormatter		= NULL;
	public $_pluginsManager		= NULL;

	function __construct($a_owner, $a_debug, $a_cfgFile = "config.php") {
//
		parent::__construct($a_owner, $a_debug);
//
		ini_set("output_buffering", 1);
//
		$this->_sessionsManager	= new cMyselfSessionsManager($this); $this->_sessionsManager->time_start = getMicroTime();
		$this->_configsManager	= new cConfigsManager($this, $a_cfgFile);
		$this->_pluginsManager	= new cPluginsManager($this);
		$this->_storagesManager	= new cMyselfStoragesManager($this,  array("type" => $this->_configsManager->ngine_db_engine, "source" => NULL, "delimiter" => $this->_configsManager->data_delimiter));
		$this->_securityManager	= new cSecurityManager($this);
		$this->_coreUtils	= new cMyselfCoreUtils($this);
		$this->_i18nManager	= new cI18NManager($this);
		$this->_contentManager	= new cContentManager($this);
		$this->_textFormatter	= new cTextFormatter($this);
//
		$this->_sessionsManager->storage	= $this->_storagesManager;
		$this->_sessionsManager->config		= $this->_configsManager;
		$this->_sessionsManager->security	= $this->_securityManager;
		$this->_sessionsManager->content	= $this->_contentManager;
		$this->_sessionsManager->plugins	= $this->_pluginsManager;
		$this->_sessionsManager->utils		= $this->_coreUtils;
		$this->_sessionsManager->i18n		= $this->_i18nManager;
		$this->_sessionsManager->formatter	= $this->_textFormatter;
		$this->_sessionsManager->core		= $this;
//		
		$this->_sessionsManager->initThis();
		$this->_i18nManager->initThis($this->_configsManager->langs_modules_path."/".$this->_sessionsManager->language."/".$this->_configsManager->default_locale_short.".php");
		if (($this->_configsManager->use_plugins) && (!is_null($this->_configsManager->plugins))) {
			$this->_pluginsManager->initThis($this->_configsManager->plugins);
		}
		$this->_contentManager->initThis();
	}

	function __destruct() {
	}
	
	function letsGo() {
		$this->_contentManager->showContent();
	}
	
	function getConfiguration() {
		if (!is_null($this->_configsManager)) {
			return $this->_configsManager->getConfiguration();
		}
	}

	function getSession() {
		if (!is_null($this->_sessionsManager)) {
			return $this->_sessionsManager->getSession();
		}
	}

	function getI18N() {
		if (!is_null($this->_i18nManager)) {
			return $this->_i18nManager->getI18N();
		}
	}
	
	function getUtils() {
		if (!is_null($this->_coreUtils)) {
			return $this->_coreUtils;
		}
	}
	
	function getPlugins() {
		if (!is_null($this->_pluginsManager)) {
			return $this->_pluginsManager;
		}
	}
	
	function getFormatter() {
		if (!is_null($this->_textFormatter)) {
			return $this->_textFormatter;
		}
	}

	function makeExports($modules) {
		$config  = $this->getConfiguration();
		$session = $this->getSession();
		
		$olduser	= $session->user['name']; $session->user['name'] = "";
		$oldrights	= $session->user['rights']; $session->user['rights'] = $config->unauthorized_user_rights;
		$oldadmin	= $session->user['isadmin']; $session->user['isadmin'] = false;

		if ($config->export_to_rss) {
			$this->makeRSS($modules);
		}
		
		if ($config->export_to_atom) {
			$this->makeATOM($modules);
		}

		$session->user['name']		= $olduser;
		$session->user['rights']	= $oldrights;
		$session->user['isadmin']	= $oldadmin;
	}

	function makeATOM($modules){
		$config  = $this->getConfiguration();
		$session = $this->getSession();
		
		$modules = explode(" ", $modules);
		
		write2log("try to make export atom03 file");
		
		$session->export_text = "";

		foreach ($modules as $module) {
			$exporter = new $config->modules_to_classes[$module]($this);
			if (in_array("forExport", get_class_methods(get_class($exporter)))) {
				write2log("try to make export atom03 file for module ".$module);
				$a = '?';
				$rss_time = gmstrftime("%Y-%m-%dT%H:%M:%SZ", time());
				$session->export_text = <<<RSSHEADER
<{$a}xml version="1.0" encoding="{$config->default_export_locale}"{$a}>
<feed version="0.3" xmlns="http://purl.org/atom/ns#">
 <title>{$config->site_name}</title>
 <link rel="alternate" type="text/html" href="{$config->site_url}" />
 <author>
  <name>{$config->ngine_author}</name>
  <email>{$config->ngine_author_email}</email>
 </author>
 <modified>{$rss_time}</modified>
 <generator>{$config->ngine_name} v{$config->ngine_version}</generator>
RSSHEADER;
				if ($exporter->forExport("atom03")) {
					$session->export_text .= "\n</feed>\n";
				
					$fp = fopen($config->export_data_path."/".$module.".atom.03.xml", "w+");
					if ($fp) {
						flock($fp, LOCK_EX);
						fwrite($fp, $session->export_text);
						flock($fp, LOCK_UN);
						fclose($fp);
					}
					write2log("making export atom03 file for module ".$module." successfully");
				} else {
					write2log("making export atom03 file for module ".$module." unsuccessfully - empty data");
				}
			}
		}

	}

	function makeRSS($modules){
		$config  = $this->getConfiguration();
		$session = $this->getSession();
		
		$modules = explode(" ", $modules);
		
		write2log("try to make export rss20 file");
		
		$session->export_text = "";
		
		foreach ($modules as $module) {
			$exporter = new $config->modules_to_classes[$module]($this);
			if (in_array("forExport", get_class_methods(get_class($exporter)))) {
				write2log("try to make export rss20 file for module ".$module);
			
				$a = '?';
				setlocale(LC_TIME, "C"); $rss_time = gmstrftime("%a, %d %b %Y %H:%M:%S GMT", time()); setlocale(LC_TIME, $config->default_locale);
				if (($config->use_gravatar) && ($config->use_gravatar_in_posts)) {
					$gravatar_url = "<image>\n<url>".$config->site_url."images/avatar.jpg</url>\n<title>".$config->site_name."</title>\n<link>".$config->site_url."</link>\n</image>\n";
				}
				$session->export_text = <<<RSSHEADER
<{$a}xml version="1.0" encoding="{$config->default_export_locale}"{$a}>
<rss version="2.0" xmlns:blogChannel="http://backend.userland.com/blogChannelModule">
<channel>
<title>{$config->site_name}</title>
<link>{$config->site_url}</link>
<description>{$config->site_name}</description>
<language>ru</language>
<managingEditor>{$config->ngine_author_email} ({$config->ngine_author_name})</managingEditor>
<webMaster>{$config->ngine_author_email} ({$config->ngine_author_name})</webMaster>
<generator>{$config->ngine_name} v{$config->ngine_version}</generator>
<pubDate>{$rss_time}</pubDate>
<lastBuildDate>{$rss_time}</lastBuildDate>
<ttl>60</ttl>
{$gravatar_url}
RSSHEADER;
				if ($exporter->forExport("rss20")) {
					$session->export_text .= "\n</channel>\n</rss>\n";
				
					$fp = fopen($config->export_data_path."/".$module.".rss.20.xml", "w+");
					if ($fp) {
						flock($fp, LOCK_EX);
						fwrite($fp, $session->export_text);
						flock($fp, LOCK_UN);
						fclose($fp);
					}
					write2log("making export rss20 file for module ".$module." successfully");
				} else {
					write2log("making export rss20 file for module ".$module." unsuccessfully - empty data");
				}
			}
		}
	}

	function remakeKeys($modules){
		$config  = $this->getConfiguration();
		$session = $this->getSession();
			
		$modules = explode(" ", $modules);
		
		write2log("try to make keys".($config->use_calendars?" and calendars ":" ")."files");
		
		foreach ($modules as $module) {
			$exporter = new $config->modules_to_classes[$module]($this);
			if (in_array("forKeys", get_class_methods(get_class($exporter)))) {
			
				write2log("try to make keys file for module ".$module);
			
				$session->export_text = "";
			
				$session->postdays = array();
			
				if ($exporter->forKeys()) {
					$text = "";
					$keys = array();
					
					$data_file = explode("\n", $session->export_text);
				 	if (!empty($data_file)) {
					foreach ($data_file as $keys_data) {
						$key_data[1] = trim(chop($key_data[1]));
						$key_data = split($config->data_delimiter, $keys_data);
						if (empty($keys[strtolower($key_data[1])])) {
							$keys{strtolower($key_data[1])} = $key_data[1].$config->data_delimiter;
						}
						$keys[strtolower($key_data[1])] .= $key_data[0]."|";
					}
					}
					
					$key_id = 1;
					foreach (array_keys($keys) as $Key) {
						if (!empty($Key)) {
							$key_data = split($config->data_delimiter, $keys[$Key]);
							$temp = explode("|", $key_data[1]);
							$temp = array_unique($temp);
							$key_data[1] = implode("|", $temp);
							$text .= $key_id.$config->data_delimiter.trim(chop($key_data[0])).$config->data_delimiter.$key_data[1]."\n";
							$key_id++;
						}
					}
				
					$session->storage->setSource($config->keys_data_path."/".$module, false);
					$session->storage->setBuffer(explode("\n", $text));
					$session->storage->Unique();
					$session->storage->Sort("CompareKeys");
					$session->storage->Save();
				
					write2log("making keys file for module ".$module." successfully");
				
					if ($config->use_calendars) {
					
						write2log("try to make calendar files for module ".$module);
						
						$text = "";
						foreach (array_keys($session->postdays) as $Key) {
							$counts = array(); $daystr = "";
							if (!empty($Key)) {
								$temp = explode("|", $session->postdays[$Key]);
								foreach ($temp as $tmp) {
									$counts[$tmp]++;
								}
						
								$temp = array_unique($temp);
								
								foreach ($temp as $tmp) {
									if (!empty($tmp)) {
										$daystr .= $tmp."/".$counts[$tmp]."|";
									}
								}
	
								$session->postdays[$Key] = $daystr;
								$text .= trim(chop($Key)).$config->data_delimiter.$session->postdays[$Key]."\n";
							}
						}
						
						$session->storage->setSource($config->calendars_data_path."/".$module, false);
						$session->storage->setBuffer(explode("\n", $text), true);
						
						write2log("making calendar files for module ".$module." successfully");
					} else {
						write2log("making keys file for module ".$module." unsuccessfully - empty data");
						if ($config->use_calendars) {
							write2log("making calendar files for module ".$module." unsuccessfully - empty data");
						}
					}
				}
			}
		}
	}

}

?>