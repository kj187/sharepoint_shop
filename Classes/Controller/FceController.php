<?php
namespace Aijko\SharepointShop\Controller;

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
class FceController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	const FAL_RELATED_RECORD_TABLE = 'tt_content';

	/**
	 * @var array
	 */
	protected $data = array();

	/**
	 * @var	tslib_cObj
	 */
	protected $contentObject;

	/**
	 * @var array
	 */
	protected $contentObjectData = array();

	/**
	 * @var \TYPO3\CMS\Extbase\Service\FlexFormService
	 */
	protected $flexFormService;

	/**
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 */
	protected $fileRepository = NULL;

	/**
	 * @var \TYPO3\CMS\Core\Resource\FileCollectionRepository
	 */
	protected $fileCollectionRepository = NULL;

	/**
	 * @param \TYPO3\CMS\Extbase\Service\FlexFormService $flexFormService
	 * @return void
	 */
	public function injectFlexFormService(\TYPO3\CMS\Extbase\Service\FlexFormService $flexFormService) {
		$this->flexFormService = $flexFormService;
	}

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param \TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	 * @api
	 */
	protected function initializeView(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface $view) {
		#$this->fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		#$this->fileCollectionRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileCollectionRepository');

		$this->contentObject = $this->configurationManager->getContentObject();
		$this->contentObjectData = $this->contentObject->data;
		$this->data = $this->flexFormService->convertFlexFormContentToArray($this->contentObjectData['pi_flexform']);
		$this->data['parent'] = $this->contentObjectData;

		$view->assign('data', $this->data);
		parent::initializeView($view);
	}

	/**
	 * @return void
	 */
	public function buttonAction() {
		$this->view->assign('variable', $this->data['title']);
	}

}
?>