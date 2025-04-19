<?php

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
	'title' => 'Redirects Export',
	'description' => 'Allows you to export redirects from the redirects module to a CSV file.',
	'category' => 'module',
	'author' => 'Ruwen Klingler',
	'state' => 'stable',
	'version' => '1.0.0',
	'constraints' => [
		'depends' => [
			'typo3' => '12.4.0-13.4.99',
		],
	],
];
