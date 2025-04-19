<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace RKL\RedirectsExport\Service;

final class CsvService
{
	/**
	 * Creates a csv string from a multidimensional array.
	 * @param array<array<mixed, int|string|null>> $lines
	 */
	public function getCsvFromArray(array $lines): string
	{
		$f = fopen('php://memory', 'r+');
		if ($f === false) {
			throw new \RuntimeException('Could not create a temporary resource in memory', 1744845731);
		}

		foreach ($lines as $line) {
			if (fputcsv($f, $line) === false) {
				throw new \Exception();
			}
		}

		rewind($f);
		$csvString = stream_get_contents($f);
		if ($csvString === false) {
			throw new \RuntimeException('Could not get csv content from stream', 1744848102);
		}
		return $csvString;
	}
}
