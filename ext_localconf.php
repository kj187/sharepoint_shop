<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['BE']['defaultPageTSconfig'] .= "\n" . '<INCLUDE_TYPOSCRIPT: source="FILE: EXT:' . $_EXTKEY . '/Configuration/TSconfig/Page/wizard.ts">';

$vendorName = 'Aijko';
$extensionName = str_replace(' ', '', ucwords(str_replace('_', ' ', $_EXTKEY)));
$flexibleContentElements = array(

	// SPButton FCE
	'FCE_Button' => array(
		'controllerActions' => array(
			'Fce' => 'button'
		),
		'nonCacheableControllerActions' => array(
			'Fce' => ''
		)
	),

);

foreach ($flexibleContentElements as $pluginName => $data) {
	$pluginSignature = strtolower($extensionName) . '_' . strtolower($pluginName);

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		$vendorName . '.' . $_EXTKEY,
		$pluginName,
		$data['controllerActions'],
		$data['nonCacheableControllerActions'],
		'CType'
	);

	$pluginContent = trim('
		tt_content.' . $pluginSignature . ' = COA
		tt_content.' . $pluginSignature . ' {
			10 >

			20 = USER
			20 {
				userFunc = tx_extbase_core_bootstrap->run
				extensionName = ' . $extensionName . '
				pluginName = ' . $pluginName . '

				view {
					templateRootPath = {$plugin.tx_sharepointshop.view.templateRootPath}
					partialRootPath = {$plugin.tx_sharepointshop.view.partialRootPath}
					layoutRootPath = {$plugin.tx_sharepointshop.view.layoutRootPath}
				}
				persistence {
					storagePid = {$plugin.tx_sharepointshop.persistence.storagePid}
				}

				settings {
					rewrittenPropertyMapper = 1
				}
			}
		}

		plugin.tx_' . strtolower($extensionName) . ' >
	');

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($extensionName, 'setup', $pluginContent, 43);
}

?>