<?php
namespace Scarbous\MrBaseConfig\Utility;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class TemplatConfigUtility {

	function loadConfig($extKex) {
		if(!file_exists(ExtensionManagementUtility::extPath($extKex).'ext_configuration.php')) return false;
		
		$baseConfigration = include ExtensionManagementUtility::extPath($extKex).'ext_configuration.php';
		if(count($baseConfigration['Extensions'])>0) {
			foreach($baseConfigration['Extensions'] as $ext) {
				array_push($baseConfigration['Typoscripts'] , 'EXT:'.$extKex.'/Extensions/'.$ext.'/Configuration/TypoScript');
			}
		}
		array_push($baseConfigration['Typoscripts'] , 'EXT:'.$extKex.'/Configuration/TypoScript');
		GeneralUtility::makeInstance('Scarbous\MrBaseConfig\Hooks\TypoScriptTemplate')->addStaticTemplates($baseConfigration['Typoscripts']);
		if(count($baseConfigration['TsConfig'])>0) {
			foreach ($baseConfigration['TsConfig'] as &$tsc) {
			  $tsc = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($extKex) . $tsc);
			  ExtensionManagementUtility::addPageTSConfig($tsc);
			}
		}
	}

}
