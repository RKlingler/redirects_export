<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace RKL\RedirectsExport\Repository;

use TYPO3\CMS\Redirects\Repository\Demand;

/**
 * Extends the demand class to allow for setting the limit
 */
final class ExportDemand extends Demand
{
	public function setLimit(int $limit): void
	{
		$this->limit = $limit;
	}
}
