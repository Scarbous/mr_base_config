<?php
	namespace Scarbous\MrBaseConfig\Service;

	use TYPO3\CMS\Core\Utility\ExtensionManagementUtility,
		TYPO3\CMS\Core\Utility\GeneralUtility;

	/**
	 * Class TemplateConfigService
	 *
	 * @package Scarbous\MrBaseConfig\Service
	 * @author Sascha Heilmeier <s.heilmeier@misterknister.com>
	 */
	class TemplateConfigService implements \TYPO3\CMS\Core\SingletonInterface
	{

		/**
		 * The Extension Key
		 * @var string
		 */
		private $extKey;

		/**
		 * Configuration array
		 * @var array
		 */
		private $baseConfiguration;

		/**
		 * TemplateConfigService constructor.
		 * @param string $extKey The Extension Key
		 */
		public function __construct($extKey)
		{
			$this->extKey = $extKey;

			if ($this->getConfiguration()) {
				$this->loadTypoScript();
				$this->loadTSConfig();
			} else {
				return false;
			}
			return true;
		}

		/**
		 * Loads the config array
		 *
		 * @return bool
		 */
		private function getConfiguration()
		{
			#return true;
			if (!file_exists(ExtensionManagementUtility::extPath($this->extKey) . 'ext_configuration.php')) {
				return false;
			}
			$this->baseConfiguration =
				require_once ExtensionManagementUtility::extPath($this->extKey) . 'ext_configuration.php';

			if (is_array($this->baseConfiguration)) {
				return true;
			}
			return false;
		}

		/**
		 * Adds the TypoScript elements to the StaticTemplatesHook
		 *
		 * @return void
		 */
		private function loadTypoScript()
		{
			$ts = array();

			foreach ($this->baseConfiguration['Typoscript'] as $domain => $config) {
				$ts[$domain]['Typoscripts'] = $config['Typoscripts'];
				if (count($config['Extensions']) > 0) {
					foreach ($config['Extensions'] as $ext) {
						array_push($ts[$domain]['Typoscripts'],
							'EXT:' . $this->extKey . '/Extensions/' . $ext . '/Configuration/TypoScript');
					}
				}
			}
			GeneralUtility::makeInstance('Scarbous\MrBaseConfig\Hooks\TypoScriptTemplate')->addStaticTemplates($ts);
		}

		/**
		 * Loads the TSConfig
		 * @return void
		 */
		private function loadTSConfig()
		{
			$ts = array();
			foreach ($this->baseConfiguration['TsConfig'] as $pid => $tSconfig) {
				$condition = '';
				if ('_DEFAULT' !== $pid) {
					$condition = '[PIDinRootline = ' . $pid . ']';
				}

				if (count($tSconfig) > 0) {
					foreach ($tSconfig as &$tsc) {
						$tsc = GeneralUtility::getUrl(ExtensionManagementUtility::extPath($this->extKey) . $tsc);
						if ($condition !== '') {
							$tsc = $condition . "\n" . $tsc . "\n[end]";
						}
						ExtensionManagementUtility::addPageTSConfig($tsc);
					}
				}
			}

		}

	}
