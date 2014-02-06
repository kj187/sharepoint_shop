<?php
namespace Aijko\SharepointShop\Hook;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Julian Kleinhans <julian.kleinhans@aijko.com>, AIJKO GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_powermail
 */
class BrowseLinks {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param array $parameter
	 * @param \TYPO3\CMS\Recordlist\Browser\ElementBrowser $elementBrowser
	 * @return string
	 */
	public function extendJScode(array $parameter, \TYPO3\CMS\Recordlist\Browser\ElementBrowser $elementBrowser) {
		return '
			function setAdditionalSharepointProductAttribute() {
				if (document.ltargetform.lsharepoint_product) {
					browse_links_setAdditionalValue("data-sharepoint-product", document.ltargetform.lsharepoint_product.value);
					return "&tx_sharepointshop[product]=" + document.ltargetform.lsharepoint_product.value;
				}
			}

			function link_current() {
				var parameters = (document.ltargetform.query_parameters && document.ltargetform.query_parameters.value) ? (document.ltargetform.query_parameters.value.charAt(0) == "&" ? "" : "&") + document.ltargetform.query_parameters.value : "";
				if (document.ltargetform.anchor_title) browse_links_setTitle(document.ltargetform.anchor_title.value);
				if (document.ltargetform.anchor_class) browse_links_setClass(document.ltargetform.anchor_class.value);
				if (document.ltargetform.ltarget) browse_links_setTarget(document.ltargetform.ltarget.value);
				if (document.ltargetform.lrel) browse_links_setAdditionalValue("rel", document.ltargetform.lrel.value);

				parameters = setAdditionalSharepointProductAttribute();

				if (cur_href!="http://" && cur_href!="mailto:") {
					plugin.createLink(cur_href + parameters,cur_target,cur_class,cur_title,additionalValues);
				}
				return false;
			}

			function link_typo3Page(id,anchor) {
				var parameters = (document.ltargetform.query_parameters && document.ltargetform.query_parameters.value) ? (document.ltargetform.query_parameters.value.charAt(0) == "&" ? "" : "&") + document.ltargetform.query_parameters.value : "";
				var theLink = \'' . $elementBrowser->siteURL . '?id=\' + id + parameters + (anchor ? anchor : "");
				if (document.ltargetform.anchor_title) browse_links_setTitle(document.ltargetform.anchor_title.value);
				if (document.ltargetform.anchor_class) browse_links_setClass(document.ltargetform.anchor_class.value);
				if (document.ltargetform.ltarget) browse_links_setTarget(document.ltargetform.ltarget.value);
				if (document.ltargetform.lrel) browse_links_setAdditionalValue("rel", document.ltargetform.lrel.value);

				parameters = setAdditionalSharepointProductAttribute();

				browse_links_setAdditionalValue("data-htmlarea-external", "");
				plugin.createLink(theLink,cur_target,cur_class,cur_title,additionalValues);
				return false;
			}
		';
	}

	/**
	 * @param array $parameter
	 * @param \TYPO3\CMS\Recordlist\Browser\ElementBrowser $elementBrowser
	 *
	 * @return string
	 */
	public function getAttributefields(array $parameter, \TYPO3\CMS\Recordlist\Browser\ElementBrowser $elementBrowser) {
		if ($elementBrowser->act == 'page' && $elementBrowser->buttonConfig && is_array($elementBrowser->buttonConfig['sharepointProductMapping.']) && $elementBrowser->buttonConfig['sharepointProductMapping.']['enabled']) {
			try {
				$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sharepoint_shop']);
				$extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::removeDotsFromTS($extensionConfiguration);
				$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
				$sharepointListsRepository = $this->objectManager->get('Aijko\\SharepointConnector\\Domain\\Repository\\Sharepoint\\ListsRepository');
				$records = $sharepointListsRepository->findRecords($extensionConfiguration['sharepointServer']['list']['article']['identifier']);

				$options = array();
				if (is_array($records) && count($records) > 0) {
					foreach ($records as $record) {
						$options[] = '<option ' . ($elementBrowser->additionalAttributes['data-sharepoint-product'] == $record['id'] ? 'selected="selected"' : '') . ' value="' . $record['id'] . '">' . $record['bezeichnung'] . ' (' . $record['title'] . ')</option>';
					}
				}

				if (count($options) > 0) {
					return '
					<tr>
						<td>Sharepoint Product:</td>
						<td colspan="3">
							<select name="lsharepoint_product">
								<option></option>
								' . implode('', $options) . '
							</select>
						</td>
					</tr>
				';
				}
			} catch(\Exception $e) {

			}
		}
	}

}

?>