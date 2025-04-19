<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use RKL\RedirectsExport\Controller\ExportController;

return [
	'export_redirects' => [
		'path' => '/export_redirects',
		'referrer' => 'required',
		'target' => ExportController::class . '::handle',
	]
];
