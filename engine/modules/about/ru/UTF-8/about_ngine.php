     <table width="95%" align="center" class="topictext" id="aboutngine">
      <tr>
       <td align="right" valign="top" width="20%"><strong>Название :</strong></td><td align="left" valign="top" width="80%"><?= $config->ngine_name; ?></td>
      </tr>
      <tr>
       <td align="right" valign="top" width="20%"><strong>Версия :</strong></td><td align="left" valign="top" width="80%"><?= $config->ngine_version; ?></td>
      <tr>
       <td align="right" valign="top" width="20%"><strong>Автор :</strong></td><td align="left" valign="top" width="80%"><a href="mailto:<?= $session->utils->hideEMail($config->ngine_author_email)."\">".$config->ngine_author; ?></a></td>
      </tr>
      <tr>
       <td align="right" valign="top" width="20%"><strong>Требования :</strong></td><td align="left" valign="top" width="80%">Apache v1.3.xx и выше или любой другой WEB-сервер с поддержкой PHP5, PHP v5.x.x и выше (с PHP4 <strong>НЕ СОВМЕСТИМ</strong>), голова на плечах и желание :)</td>
      </tr>
      <tr>
       <td align="right" valign="top" width="20%"><strong>Условия :</strong></td><td align="left" valign="top" width="80%">распространяется по лицензии "<a href="http://www.opensource.org/licenses/artistic-license.php" target="_blank" <?= ($config->use_google_nofollow?"rel=\"nofollow\"":""); ?>>Artistic License</a>", желательна ссылка на автора проекта.<br />Разумеется <strong>АВТОР НЕ НЕСЁТ НИКАКОЙ ОТВЕТСТВЕННОСТИ И НЕ ДАЁТ НИКАКИХ ГАРАНТИЙ ПРИ ИСПОЛЬЗОВАНИИ ДАННОГО ПРОГРАММНОГО ОБЕСПЕЧЕНИЯ В ЛЮБЫХ УСЛОВИЯХ И ПРИ ЛЮБЫХ ОБСТОЯТЕЛЬСТВАХ! ВСЕ В ВАШИХ РУКАХ! Я ВАС НЕ ПРИНУЖДАЛ ЭТО ДЕЛАТЬ!</strong> :)</td>
      </tr>
      <tr>
       <td align="right" valign="top" width="20%"><strong>Фишки-плюшки :</strong></td>
       <td align="left" valign="top" width="80%">
       - легко расширяемая, модульно-классовая архитектура;<br />
       - менеджер подключаемых модулей (plugins) c множеством hook'ов;<br />
       - модуль ведения дневника (blog) с комментариями, коллективного в том числе;<br />
       - визуальные стили и цветовые темы;<br />
       - поддержка экспорта контента в RSS v2.0 и ATOM v0.3;<br />
       - поддержка WackoWiki-разметки (реализованная с помощью <a href="<?= $session->utils->makeHRURL("http://shadow.b0b.org/?module=blog&action=keys&key=WackoFormatter"); ?>">WackoFormatter'а</a>);<br />
       - поддержка ключевых слов, фраз и категорий для поиска и группировки постов;<br />
       - поддержка "чёрного" списка IP-адресов для болкировки некоторых клиентов;<br />
       - собственная реализация <a href="<?= $session->utils->makeHRURL("http://shadow.b0b.org/?module=blog&action=keys&key=ЧПУ"); ?>">ЧПУ</a> <STRONG>без использования mod_rewrite</STRONG>;<br>
       - также поддержка классических URL'ов (например <a href="/?module=blog&action=show">так</a>);<br /> 
       - менеджер личных закладок пользователей (добавление, удаление и просмотр);<br />
       - менеджер общих закладок, создаваемых на основе OPML-файла;<br />
       - права пользователей на возможные действия в каждом модуле задаются отдельно;<br />
       - администраторские и модераторские права у одного или нескольких пользователей;<br />
       - менеджер хранения информации универсален и расширяем, по умолчанию в виде текста;
       </td>
      </tr>
      <tr>
       <td align="right" valign="top" width="20%"><strong>Хочется :</strong></td>
       <td align="left" valign="top" width="80%">
       - XML-RPC интерфейс;<br />
       - ключевые слова с отношениями "один ко многим";<br />
       </td>
      </tr>
     </table>
