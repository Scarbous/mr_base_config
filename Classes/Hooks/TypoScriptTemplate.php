<?php
namespace Scarbous\MrBaseConfig\Hooks;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\TypoScript\TemplateService;


class TypoScriptTemplate implements \TYPO3\CMS\Core\SingletonInterface {

  /**
   * Path of static templates from extensions
   *
   * @var array
   */
  protected $staticTemplates = array();

  /**
   * Includes static template from extensions
   *
   * @param array $params
   * @param t3lib_TStemplate $pObj
   * @return void
   */
  public function preprocessIncludeStaticTypoScriptSources(array $params, TemplateService $pObj) {
    if (isset($params['row']['root'])) {
      $staticTemplatesFromBackend = GeneralUtility::trimExplode(',', $params['row']['include_static_file']);
      $staticTemplates = array_merge($this->getStaticTemplates(), $staticTemplatesFromBackend);
      $params['row']['include_static_file'] = implode(',', array_unique($staticTemplates));
    }
  }

  /**
   * Adds a static template path
   *
   * @param string $staticTemplate
   * @return void
   */
  public function addStaticTemplate($staticTemplate) {
    $this->staticTemplates[] = $staticTemplate;
  }

  /**
   * Adds a static multiple templates path
   *
   * @param array $staticTemplates
   * @return void
   */
  public function addStaticTemplates(array $staticTemplates) {
    foreach ($staticTemplates as $staticTemplate) {
      $this->staticTemplates[] = $staticTemplate;
    }
  }

  /**
   * Returns the static template paths
   *
   * @return array
   */
  public function getStaticTemplates() {
    return $this->staticTemplates;
  }

}	