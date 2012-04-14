<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * action controller.
 *
 * @author Susanne Moog <typo3@susannemoog.de>
 * @package Extension Manager
 * @subpackage Controller
 */
class Tx_Extensionmanager_Controller_ConfigurationController extends Tx_Extensionmanager_Controller_AbstractController {

	/**
	 * @var Tx_Extensionmanager_Domain_Repository_ConfigurationItemRepository
	 */
	protected $configurationItemRepository;

	/**
	 * @param Tx_Extensionmanager_Domain_Repository_ConfigurationItemRepository $configurationItemRepository
	 * @return void
	 */
	public function injectConfigurationItemRepository(Tx_Extensionmanager_Domain_Repository_ConfigurationItemRepository $configurationItemRepository){
		$this->configurationItemRepository = $configurationItemRepository;
	}

	public function showConfigurationFormAction() {
		$extension = $this->request->getArgument('extension');
		$extension = array_merge($extension, $GLOBALS['TYPO3_LOADED_EXT'][$extension['key']]);
		$configuration = $this->configurationItemRepository->findByExtension($extension);
		$this->view
			->assign('configuration', $configuration)
			->assign('extension', $extension);
	}

	/**
	 * @param array $config
	 * @param string $extensionKey
	 * @return void
	 */
	public function saveAction(array $config, $extensionKey) {
		/** @var $configurationUtility Tx_Extensionmanager_Utility_Configuration */
		$configurationUtility = $this->objectManager->get('Tx_Extensionmanager_Utility_Configuration');
		$currentFullConfiguration = $configurationUtility->getCurrentConfiguration($extensionKey);
		$newConfiguration = t3lib_div::array_merge_recursive_overrule($currentFullConfiguration, $config);

		$strippedConfiguration = array();
		foreach($newConfiguration as $configurationKey => $configurationValue) {
			$strippedConfiguration[$configurationKey]['value'] = $configurationValue['value'];
		}

		$configurationUtility->writeConfiguration($strippedConfiguration, $extensionKey);
		$this->redirect('showConfigurationForm', NULL, NULL, array('extension' => array('key' => $extensionKey)));
	}


}
?>
