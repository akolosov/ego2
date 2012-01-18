WackoFormatter
--------
Version 2.1.1.
http://wackowiki.com/projects/wackoformatter
--------

This parser is a Wiki to HTML renderer, used in WackoWiki and NPJ projects.

Ths version is a standalone, ready to simple or advanced usage.

If you found any bugs in this parser, please inform 
maintainer, Roman Ivanov -- ICQ:551593 or mailto:thingol@mail.ru

Please, subscribe to http://wackowiki.com/projects/wackoformatter/updates/revisions.xml feed 
in order to receive notices when WackoFormatter will be updated.

-- WackoWiki team ( http://wackowiki.com/team ).



--------
Version history:
--------
2.1.1.
  * Bug with ""//emphasis http://somelink.ru emphasis-end//"" fixed.
2.1.0.
  * Added new example, ##example_highlight.php## which allows to use all highlighters from WackoWiki.
  * Now WackoFormatter distributed as two packages: 
    1. minimal 
    2. with highlighters
2.0.8.
  * Included classes typografica & paragrafica (see http://pixel-apes.com/typografica for details).
  * Example ##example_adv.php## now includes support for typografica & paragrafica.
2.0.7.
  * Now table elements doesn't renders outside a table.
  * Formatter adds closing tag for all non-closed <table> tags.
2.0.6.
  * Now header of any level can be ended with only two ==.
  * Fixed numerous bugs with blockquote.
  * New syntax: one-line citation:
> You wrote
>> Me wrote
2.0.1.
  * new options: 
    * disable_bracketslinks
    * disable_npjlinks
    * disable_formatters
2.0.
  * First public release as standalone project.
1.x.
  * Part of WackoWiki and NPJ projects.



--------
Documentation:
--------

See docs/english/usage.html for documentation on integrating formatter in your application.

See docs/english/format.html for documentation on text formatting rules.