<?php
namespace Aijko\SharepointShop\UserFunc;

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
 * @package sharepoint_shop
 */
class FlexformFields {

	/**
	 * @param array $parentArray
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $formEngine
	 *
	 * @return string
	 */
	public function getSharepointProducts(array $parentArray, \TYPO3\CMS\Backend\Form\FormEngine $formEngine) {

		#$formField  = '<div style="padding: 5px; background-color: ' . $color . ';">';
		$formField .= '<input type="text" name="' . $parentArray['itemFormElName'] . '"';
		$formField .= ' value="' . htmlspecialchars($parentArray['itemFormElValue']) . '"';
		$formField .= ' onchange="' . htmlspecialchars(implode('', $parentArray['fieldChangeFunc'])) . '"';
		$formField .= $parentArray['onFocus'];
		#$formField .= ' /></div>';
		return $formField;
	}

}

?>