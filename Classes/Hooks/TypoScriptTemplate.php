<?php
	namespace Scarbous\MrBaseConfig\Hooks;

	use TYPO3\CMS\Core\Utility\GeneralUtility,
		TYPO3\CMS\Backend\Utility\BackendUtility,
		TYPO3\CMS\Core\TypoScript\TemplateService,
		Scarbous\MrBaseConfig\Utility\DivUtility;

	/**
	 * Class TypoScriptTemplate
	 * @package Scarbous\MrBaseConfig\Hooks
	 * @author Sascha Heilmeier <s.heilmeier@misterknister.com>
	 */
	class TypoScriptTemplate implements \TYPO3\CMS\Core\SingletonInterface
	{

		/**
		 * Path of static templates from extensions
		 *
		 * @var array
		 */
		protected $staticTemplates = array();

		/**
		 * Includes static template from extensions
		 *
		 * @param array $params Hook parameter
		 * @param TemplateService $pObj The TemplateService
		 *
		 * @return void
		 */
		public function preprocessIncludeStaticTypoScriptSources(array $params, TemplateService $pObj)
		{
			if (isset($params['row']['root'])) {
				$staticTemplatesFromBackend = GeneralUtility::trimExplode(',', $params['row']['include_static_file']);
				if (is_array($staticTemplates = $this->getStaticTemplates())) {
					$domain = DivUtility::getSysDomain($pObj->absoluteRootLine[0]['uid']);
					if ($staticTemplates[$domain]) {
						$staticTemplates = $staticTemplates[$domain];
					}
					if ($staticTemplates['_DEFAULT']) {
						$staticTemplates = $staticTemplates['_DEFAULT'];
					}
					if (is_array($staticTemplates['Typoscripts'])) {
						$staticTemplates = $staticTemplates['Typoscripts'];
					}
					$staticTemplates = array_merge($staticTemplates, $staticTemplatesFromBackend);
					$params['row']['include_static_file'] = implode(',', array_unique($staticTemplates));
				}
			}
		}

		/**
		 * Adds a static multiple templates path
		 *
		 * @param array $staticTemplates List of TypoScript's
		 *
		 * @return void
		 */
		public function addStaticTemplates(array $staticTemplates)
		{
			foreach ($staticTemplates as $domain => $staticTemplate) {
				$this->staticTemplates[$domain] = $staticTemplate;
			}

		}

		/**
		 * Returns the static template paths
		 *
		 * @return array
		 */
		public function getStaticTemplates()
		{
			return $this->staticTemplates;
		}

	}
