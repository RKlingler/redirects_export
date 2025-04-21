<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace RKL\RedirectsExport\Tests\Unit\Repository;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use RKL\RedirectsExport\Repository\ExportDemand;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(ExportDemand::class)]
class ExportDemandTest extends UnitTestCase
{
	protected ExportDemand $subject;

	protected function setUp(): void
	{
		parent::setUp();
		$this->subject = new ExportDemand();
	}

	#[Test]
	public function allowsToSetLimitAfterInitialization(): void
	{
		$this->subject->setLimit(42);
		self::assertEquals(42, $this->subject->getLimit());
	}
}
