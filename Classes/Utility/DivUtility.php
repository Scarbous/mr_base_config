<?php
	namespace Scarbous\MrBaseConfig\Utility;

	use TYPO3\CMS\Core\Utility\GeneralUtility,
		TYPO3\CMS\Core\Utility\RootlineUtility;

	/**
	 * Helper Class
	 *
	 * Class DivUtility
	 *
	 * @package Scarbous\MrBaseConfig\Utility
	 */
	class DivUtility
	{
		/**
		 * Get rootline of the current Page
		 *
		 * @return bool
		 */
		static function getRootLine()
		{
			if ($GLOBALS['TSFE']->id > 0) {
				$currentPid = $GLOBALS['TSFE']->id;
			} else {
				$currentPid = (int)GeneralUtility::_GP('id');
			}
			if ($currentPid > 0) {
				$rootline = GeneralUtility::makeInstance('TYPO3\CMS\Core\Utility\RootlineUtility', $currentPid);
				return $rootline->get()[0]['uid'];
			}
			return false;
		}

		/**
		 * Get SysDomain from rootline
		 *
		 * @param int $rootPid Rootline pid
		 *
		 * @return bool
		 */
		static function getSysDomain($rootPid = null)
		{
			if ($rootPid === null) {
				$pid = self::getRootLine();
			}
			if ($rootPid) {
				$domain = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('domainName', 'sys_domain',
					'redirectTo = "" AND hidden=0 AND pid=' . $rootPid);
				return $domain['domainName'];
			}
			return false;
		}

	}
