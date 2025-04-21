<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace RKL\RedirectsExport\Tests\Unit\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use RKL\RedirectsExport\Service\CsvService;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

#[CoversClass(CsvService::class)]
class CsvServiceTest extends UnitTestCase
{
	protected CsvService $subject;

	protected function setUp(): void
	{
		parent::setUp();
		$this->subject = new CsvService();
	}

	#[Test]
	public function convertsArrayToCsvString(): void
	{
		$testData = [
			['A', 'B', 'C D'],
			[1, 2, null]
		];
		self::assertEquals("A,B,\"C D\"\n1,2,\n", $this->subject->getCsvFromArray($testData));
	}
}
