<?php
namespace TYPO3\CMS\Core\Log\Processor;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * A log processor that does nothing. Used in unit tests.
 *
 * @author Steffen Gebert <steffen.gebert@typo3.org>
 */
class NullProcessor extends AbstractProcessor {

	/**
	 * Processes a log record and returns the same.
	 *
	 * @param \TYPO3\CMS\Core\Log\LogRecord $logRecord The log record to process
	 * @return \TYPO3\CMS\Core\Log\LogRecord The processed log record with additional data
	 */
	public function processLogRecord(\TYPO3\CMS\Core\Log\LogRecord $logRecord) {
		return $logRecord;
	}

}
