<?php

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

if (!defined('TYPO3_MODE')) die ('Access denied.');


// Workaround - extbase doesnt detect the right alternative implementation from sharepoint_connector typoscript setup
$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\Container\\Container');
$extbaseObjectContainer->registerImplementation('Aijko\SharepointConnector\Service\SharepointDriverInterface', 'Aijko\SharepointConnector\Service\Driver\Soap');

// SignalSlot
#$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
#$signalSlotDispatcher->connect('Tx_Powermail_Controller_FormsController', 'createActionBeforeRenderView', 'Aijko\\SharepointShop\\Finisher\\Persistence', 'process');

?>