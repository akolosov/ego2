<?php

// параметры движка и сведения о нем
    $this->ngine_name				= cEngineConfig::NAME;
    $this->ngine_version			= cEngineConfig::VERSION_NUM."/".cEngineConfig::VERSION_NAME;
    $this->ngine_author				= cEngineConfig::AUTHOR;
    $this->ngine_author_uin			= cEngineConfig::ICQ;
    $this->ngine_author_email			= cEngineConfig::EMAIL;
    $this->ngine_url				= cEngineConfig::SITE;
    $this->ngine_db_engine			= "text";
    $this->ngine_modules			= array("about", "blog", "gizmo", "comments");
    $this->ngine_invisible_modules		= array();
    $this->ngine_validities			= array("css20" => false,
						        "xhtml4x" => false,
							"rss20" => true,
							"atom03" => true);
    $this->debug_mode				= cCoreConfig::DEBUG_MODE;
    $this->log_debug_mode			= cCoreConfig::FULL_DEBUG_MODE;
    $this->log_errors				= cCoreConfig::FULL_DEBUG_MODE;
    $this->log_file_name			= cCoreConfig::LOGS_DIR."/".strftime("%d.%m.%Y", time());
//
    $this->modules_to_classes			= array("blog" => "cBlogsContent",
							"gizmo" => "cGizmosContent",
    							"comments" => "cCommentsContent",
    							"about" => "cAboutContent",
    							"addons" => "cAddonsContent");
// настройка прав доступа пользователей
    $this->rights_module_delimiter		= cSecurityLevels::DELIMITER;
    $this->right_to_write			= cSecurityLevels::WRITE;
    $this->right_to_read			= cSecurityLevels::READ;
    $this->right_to_comment			= cSecurityLevels::COMMENT;
    $this->right_to_change			= cSecurityLevels::CHANGE;
    $this->right_to_delete			= cSecurityLevels::DELETE;
    $this->right_to_bookmark			= cSecurityLevels::BOOKMARK;
    $this->right_to_keywords			= cSecurityLevels::KEYWORD;
    $this->default_user_rights			= "about=r".$this->rights_module_delimiter."blog=rwecb".$this->rights_module_delimiter."comments=rwexcb".$this->rights_module_delimiter."gizmo=rc";
    $this->unauthorized_user_rights		= "about=r".$this->rights_module_delimiter."blog=rc".$this->rights_module_delimiter."comments=rwexcb".$this->rights_module_delimiter."gizmo=rc";
    $this->categories_allowed_to_comment	= array("blog" => array("", "comment"),
							"gizmo" => array("comment"));
    $this->categories_allowed_to_view		= array("blog" => array("", "comment", "!comment"),
							"comments" => array("", "comment"),
							"gizmo" => array("", "comment", "!comment"));
    $this->public_user_name			= "public";
    $this->external_link_name			= "external";

// настройка значений по умолчанию
    $this->default_count			= 5;
    $this->default_width			= "98%";
    $this->default_align			= "center";
    $this->default_theme			= "spike";
    $this->default_style			= "ghost";
    $this->default_module			= "blog";
    $this->default_action			= "show";
    $this->max_file_size			= 5120000;

    $this->default_locale			= "ru_RU.UTF-8";
    $this->default_locale_short			= "UTF-8";
    $this->default_export_locale		= "UTF-8";
    $this->default_safe_locale			= "KOI8-R";

    $this->default_locales			= array("ru" => "ru_RU.UTF-8",
							"en" => "en_US.UTF-8");
    $this->default_locales_short		= array("ru" => "UTF-8",
							"en" => "UTF-8");
    $this->default_export_locales		= array("ru" => "UTF-8",
							"en" => "UTF-8");
    $this->default_safe_locales			= array("ru" => "KOI8-R",
							"en" => "ISO-8859-1");
							
    $this->default_language			= "ru";
    $this->data_delimiter			= cCoreConfig::DELIMITER;
    $this->default_method			= "POST";

// настройка параметров сайта
    $this->site_path				= "/var/www/ego/dev";
    $this->site_url				= "http://ego.dev.b0b.org/";
    $this->site_name				= "ЭГОстимулятор [персональный]";
    $this->site_short_name			= "ЭГОстимулятор";
    $this->site_email				= "ego@ego.b0b.org";

// настройка относительных путей
    $this->shots_image_path			= "images/shots";
    $this->modules_path				= cCoreConfig::MODULES_PATH;
    $this->classes_path				= cCoreConfig::CLASSES_PATH;
    $this->templates_path			= cCoreConfig::TEMPLATES_PATH;
    $this->data_path				= "data";
    $this->about_modules_path			= $this->modules_path."/about";
    $this->admin_modules_path			= $this->modules_path."/admin";
    $this->comments_modules_path		= $this->modules_path."/comments";
    $this->blog_modules_path			= $this->modules_path."/blog";
    $this->gizmo_modules_path			= $this->modules_path."/gizmo";
    $this->langs_modules_path			= $this->modules_path."/langs";
    $this->styles_modules_path			= $this->templates_path;
    $this->themes_modules_path			= $this->modules_path."/themes";
//
    $this->users_data_path			= $this->data_path."/users";
    $this->comments_data_path			= $this->data_path."/comments";
    $this->blog_data_path			= $this->data_path."/blog";
    $this->gizmo_data_path			= $this->data_path."/gizmo";
    $this->counters_data_path			= $this->data_path."/comments/1/counters";
    $this->hits_count_data_path			= $this->data_path."/hits";
    $this->locks_data_path			= $this->data_path."/locks";
    $this->notify_data_path			= $this->data_path."/comments/notify";
    $this->boards_data_path			= $this->data_path."/boards";
    $this->export_data_path			= $this->data_path."/export";
    $this->keys_data_path			= $this->data_path."/keys";
    $this->calendars_data_path			= $this->data_path."/calendars";
    $this->bookmarks_data_path			= $this->data_path."/bookmarks";
    $this->links_data_path			= $this->data_path."/links";
    $this->categories_data_path			= $this->data_path."/categories";
    $this->themes_data_path			= $this->data_path."/themes";
    $this->styles_data_path			= $this->data_path."/styles";
    $this->blacklist_data_path			= $this->data_path."/blacklist";
    $this->history_data_path			= $this->data_path."/history";
    $this->logs_data_path			= $this->data_path."/logs";
    $this->cache_data_path			= $this->data_path."/cache";
    $this->menus_data_path			= $this->data_path."/menus";

// прочие параметры
// максимальная количество постов всего в разделе
    $this->max_count				= 1000000;
// минимальная длина индексируемого ключа    
    $this->min_key_length			= 2;
// максимальная отображаемая длинна ключа, отображаемого  в списке
    $this->max_key_length			= 20;
// максимальная отображаемая длинна закладки, отображаемого  в списке
    $this->max_bookmark_length			= 25;
// максимальная отображаемая длинна ссылки, отображаемой  в списке
    $this->max_link_length			= 20;
// максимальная отображаемая длинна заголовка комментария, отображаемого  в списке
    $this->max_comment_length			= 20;
// максимальная отображаемая длинна поста, отображаемого в списке (0 - не имеет значение)
    $this->max_text_length			= 0;
// количество ключей в секции дополнительно
    $this->keys_count_on_addons			= 15;
// количество закладок в секции дополнительно
    $this->bookmarks_count_on_addons		= 25;
// максимальная отображаемая длинна поста, отображаемого в RSS и прочих (0 - не имеет значение)
    $this->max_export_text_length		= 0;
// количество тем, публикуемых в RSS-feed и прочих (0 - все)
    $this->topics_count_in_export		= 20;
// количество коментариев в секции дополнительно
    $this->comments_count_on_addons		= 10;
// don't touch this (needed for HRURL)
    $this->modules_words_match			= "/^blog$|^gizmo$|^about$|^comments$|^theme$|^style$|^language$|^auth$|^unauth$/i";
// don't touch this (needed for HRURL)
    $this->actions_words_match			= "/^show$|^add$|^edit$|^keys$|^search$|^key$|^subj$|^subjects$|^category$|^bookmarks$|^rss20$|^atom03$|^author$|^trackback$|^save$|^archive$/i";
// don't touch this (needed for HRURL)
    $this->subactions_words_match		= "/^change$|^append$|^delete$|^undelete$|^all$|^last$/i";
// ключи для индексации берутся только специально введенные. Иначе индексируются все слова в тексте.
    $this->keys_only_in_tags			= true;
// темы постов автоматически заносятся в ключевые темы
    $this->keys_in_titles			= false;
// отправлять эл.письмо автору темы с уведомлением, когда ее прокоментировали
    $this->send_email_to_author			= true;
// вставлять подпись автора в конце заметки
    $this->authors_sign				= false;
// отправлять в эл.письме автору темы с уведомлением текст коментария
    $this->send_text_with_email			= true;
// форма для ввода коментария находится внизу страницы, после всех раннее введенных коментариев или после обсуждаемого текста
    $this->comment_form_at_down			= true;
// сортировать события по порядку с первого до последнего (false) или наоборот (true)    
    $this->blog_reverse_sort			= true;
// сортировать ёжиков по порядку с первого до последнего (false) или наоборот (true)    
    $this->gizmo_reverse_sort			= true;
// сортировать комментарии по порядку с первого до последнего (false) или наоборот (true)    
    $this->comments_reverse_sort		= false;
// автоматически цитировать основной пост при комментировании
    $this->auto_quote_in_comments		= false;
// разрешить добавлени префикса mailto: при цитировании
    $this->mailto_in_quoted_comments		= false;
// автоматически добавлять новых пользователей
    $this->auto_add_new_users			= false;
// разрешена-ли оффициальная авторизация через форму ?module=auth
    $this->authorization_is_allowed		= false;
// разрешить использование ЧПУ (ЧеловекоПонятный УРЛ)
    $this->use_HRURL				= true;
// скрывать email-адреса в постах и комментариях
    $this->hide_email				= true;
// заменитель классической "собачки" (@) в email-адресах при hide_email = true
    $this->at_replace				= "[kitty]";
// заменять строку вида <a href="http://somelink">http://somelink/</a> на <a href="http://somelink">[ссылка]</a>
    $this->replace_link				= true;
// fake'овый адрес на случай пустого e-mail'а
    $this->phantom_email			= "somebody.sometimes@somewhere.something.to.do";
// разрешить пустой e-mail в коментариях (заменяется на phantom_email)
    $this->empty_email_in_comments		= true;
// разрешить использование WackoWiki-тэгов для форматирования текста
    $this->use_wackoformatter			= true;
// неудаляемые html-тэги
    $this->nonstriped_tags			= "<br><blockquote><cite><a><img>";
    $this->nonstriped_safe_tags			= "<br><blockquote><cite><img>";
// пункты секции дополнительно по модулям
    $this->addons_by_modules    		= array("blog" => array("search", "calendar", "keys", "comments"),
							"comments" => array("comments"),
							"gizmo" => array("menu", "search", "calendar", "keys", "comments"));
// пункты секции закладки по модулям
    $this->bookmarks_by_modules    		= array("blog" => "readme permanent friends public",
							"comments" => "readme permanent friends public",
							"gizmo" => "permanent");
// поиск разрешен в модулях
    $this->search_in_modules    		= array("blog", "gizmo");
// обсуждение разрешено в модулях
    $this->comments_in_modules    		= array("blog", "comments", "gizmo");
// модули экспортируются в rss|atom
    $this->export_in_modules			= array("blog", "gizmo");
// секция дополнительно видна при действиях
    $this->no_addons_in_actions			= array("keys", "bookmarks", "subjects", "add", "edit");
// секция дополнительно не видна при sub-действиях
    $this->no_addons_in_subactions		= array("append", "change");
// секция дополнительного меню не видно при sub-действиях
    $this->no_maintances_in_subactions		= array("append", "change");
// sub-действия, при которых можно делать отбор по чему-либо
    $this->subactions_allowed_to_select		= array("", "all", "last");
// разрешить использование категорий событий
    $this->use_categories			= true;
// разрешить отображение значка категорий событий
    $this->show_categories			= false;
// разрешить использование закладок
    $this->use_bookmarks			= true;
// разрешить использование коментариев
    $this->use_comments				= true;
// разрешить использование ключевых слов
    $this->use_keywords				= true;
// разрешить использование дополнительных ссылок в формах
    $this->use_url_forms			= true;
// разрешить использование календаря
    $this->use_calendars			= true;
// разрешить использование поиска
    $this->use_search				= true;
// разрешить использование дополнительных меню
    $this->use_menus				= false;
// разрешить ведение истории посещений
    $this->use_history				= true;
// разрешить ведение журнала событий
    $this->use_log				= true;
// использовать фишку Гугля для борьбы со спамом
    $this->use_google_nofollow    		= false;
// разрешить использование визуальных стилей
    $this->use_visual_styles			= false;
// разрешить использование визуальных цветовых тем
    $this->use_visual_themes			= true;
// показывать заметки только за выбранный (или текущий) месяц
    $this->show_all_mounth			= false;
// в какие форматы экспортировать
// экспорт в RSS 2.0
    $this->export_to_rss			= true;
// экспорт в ATOM 0.3
    $this->export_to_atom			= true;
// экспортируем в форматах
    $this->exporters_format			= array("rss20", "atom03");
// пересоздавать экспортные файлы по запросу
    $this->remake_exports_at_request		= true;
// экспорт в OPML
    $this->export_to_opml			= true;
    $this->import_from_opml			= false;
    $this->opml_data_path			= $this->export_data_path."/exports.opml";
// разрешить использование "чёрного" списка IP-адресов
    $this->use_blacklist			= true;
// куда переадресовывать клиентов с "чёрным" IP
    $this->blacklist_redirect_to		= "http://www.uk-most.ru/ooops.html";
// ключевые слова может добавлять только администратор и пользователи, имееющие на это права
    $this->keywords_is_readonly			= true;
// использовать Advanced Web Statistics
    $this->use_awstats				= true;
    $this->awstats_url				= $this->site_url."cgi-bin/awstats.pl?config=ego";
// использовать сервис GRAvatar.com в коментариях
    $this->use_gravatar				= true;
    $this->gravatar_url				= "http://www.gravatar.com";
// использовать сервис GRAvatar.com в заметках
    $this->use_gravatar_in_posts		= true;
    $this->gravatar_size			= 40;
    $this->gravatar_default			= $this->site_url."images/defavatar.png";
// использовать "мягкие" переносы
    $this->use_softhyphen			= false;
// подключаемые модули
    $this->use_plugins				= true;
    $this->plugins				= array(cHooks::beforeShowPost		=> array("cBeforeShowGRAvatarPlugin"	=> NULL),
							cHooks::afterPostFormProcess	=> array("cPostAuditorCheckerPlugin"	=> NULL),
							cHooks::afterShowPostForm	=> array("cPostAuditorMakerPlugin"	=> NULL)
							);
// показывать ли рекламу Google AdSense
    $this->use_adsense				= false;
//
    $this->use_technorati			= true;
// настройки для cPostAuditorMaker и cPostAuditChecker
    $this->PAM_digits_count			= 6;
    $this->PAM_lines_count			= 0;
    $this->PAM_in_modules			= array("comments");
// определять Wiki-слова или только по знаку в начале слова (/, !, ~)
    $this->gizmo_tag_wikiwords			= true;
// автоматически определять Wiki-слова или только по знаку в начале слова (/, !, ~)
    $this->gizmo_auto_tag_wikiwords		= false;
//
?>
