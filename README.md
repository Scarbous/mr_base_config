Mr. Base Config
=========

## What does it do?

EXT:mr_base_config helps you to organize your TypoScript and TSConfig in your Template Extension.

## Installation

1. Basicly download and install the extension.

2. Creat a ext_configuration.php in your Template-Extension and add the config like:
```php
// ext_configuration.php
return array(
	Typoscripts => [
		'EXT:news/Configuration/TypoScript',
		'EXT:css_styled_content/static',
	],
	Extensions => [
		'news',
	],
	Tsconfig => array(
		'Configuration/TsConfig/Page/Rte.ts',
		'Configuration/TsConfig/Page/Config.ts',
		'Configuration/TsConfig/User/Config.ts'
	)
);
```

3. To load the Configfile
```php
// ext_localconf.php
\Scarbous\MrBaseConfig\Utility\TemplatConfigUtility::loadConfig($_EXTKEY);
```

## Based on

That the system can do the job your Template Extension needs the following FolderStructur:

* template_extension
  *  Configuration
    * TypoScript
      * setup.txt
      * constants.txt
  * Extensions
    * news
      * Configuration
        * TypoScript
          * setup.txt
          * constants.txt
