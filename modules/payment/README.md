# Internationalization (i18n)

## Setup gettext

https://www.youtube.com/watch?v=2UXSdTNPlPA

phpinfo() -> find location of php.ini

uncomment in php.ini:
;extension=gettext

```shell
sudo apt-get install poedit
sudo poedit
```

create .po file -> locales/hu_HU/LC_MESSAGES/messages.po

parse project directory

create translations -> save

compile .po to .mo (machine object)


find installed locales (OS), install missing ones if needed:

```shell
locale -a
sudo apt-get install language-pack-de-base
```

Example for Hungarian language: hu_HU.utf8

".utf8" is needed! Never omit it!


add this to ignition.php:

```php
// i18n localization with gettext
$locale = 'hu_HU.utf8';
putenv("LANG=$locale");
putenv("LANGUAGE=$locale");
setlocale(LC_ALL, $locale);

$domain = 'messages';
textdomain($domain);
bindtextdomain($domain, __DIR__ . '/locales');
bind_textdomain_codeset($domain, 'UTF-8');
```

## Usage

```php
echo gettext('test');
echo _('test2');
```

## Useful

extract locale from superglobals

```php
if (isset($_GET["locale"])) {
$locale = $_GET["locale"];
}
else if (isset($_SESSION["locale"])) {
$locale  = $_SESSION["locale"];
}
else {
$locale = "en_UK";
}

// https://gist.github.com/bosskovic/5930896

  $domain = "example";
  bindtextdomain($domain, "Locale"); 
  bind_textdomain_codeset($domain, 'UTF-8');

  textdomain($domain);

  // can use multiple domains!!!
  $domain2 = "example2";
  bindtextdomain($domain2, "Locale"); 
  bind_textdomain_codeset($domain2, 'UTF-8');
  
  $user = "Curious gettext tester";

  // _() is an alias of gettext()
  echo _("Let’s make the web multilingual.");
  echo _("We connect developers and translators around the globe 
on Lingohub for a fantastic localization experience.");

  echo sprintf(_('Welcome back, %1$s! Your last visit was on %2$s', $user, date('l'));

  // dgettext() is similar to _(), but it also accepts a domain name if a string from
  // a domain other the one set by textdomain() needs to be displayed
  echo dgettext("example2", "");

  // ngettext() is used when the plural form of the message is dependent on the count
  echo ngettext("%d page read.", "%d pages read.", 1); //outputs a form used for singular
  echo ngettext("%d page read.", "%d pages read.", 15); //outputs a form used when the count is 15
```
