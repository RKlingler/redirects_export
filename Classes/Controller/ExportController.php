<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace RKL\RedirectsExport\Controller;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RKL\RedirectsExport\Repository\ExportDemand;
use RKL\RedirectsExport\Service\CsvService;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Frontend\Typolink\LinkFactory;
use TYPO3\CMS\Frontend\Typolink\UnableToLinkException;
use TYPO3\CMS\Redirects\Repository\RedirectRepository;

#[AsController]
final class ExportController
{
	public function __construct(
		private readonly RedirectRepository $redirectRepository,
		private readonly LinkFactory $linkFactory,
		private readonly CsvService $csvService,
		private readonly ResponseFactoryInterface $responseFactory,
	) {}


	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		$exportDemand = new ExportDemand();
		$count = $this->redirectRepository->countRedirectsByByDemand($exportDemand);
		$exportDemand->setLimit($count);

		$redirects = $this->redirectRepository->findRedirectsByDemand($exportDemand);
		$csvData = [];

		foreach ($redirects as $redirect) {
			// add rendered url or empty string if the redirect target is broken
			try {
				$linkResult = $this->linkFactory->createUri($redirect['target']);
				$redirect['target_url'] = $linkResult->getUrl();
			} catch (UnableToLinkException $e) {
				$redirect['target_url'] = '';
			}

			// add formatted duplicates of datetime columns
			foreach (['updatedon', 'createdon', 'starttime', 'endtime', 'lasthiton'] as $column) {
				if (array_key_exists($column, $redirect)) {
					$redirect[$column . '_formatted'] = ($redirect[$column] !== 0 ? date('Y-m-d H:i:s', $redirect[$column]) : 0);
				}
			}

			$csvData[] = $redirect;
		}

		// add headings
		array_unshift($csvData, array_keys($csvData[0]));

		$fileContents = $this->csvService->getCsvFromArray($csvData);
		return $this->generateDownloadResponse($fileContents, 'sys_redirect.csv');
	}


	private function generateDownloadResponse(string $fileContents, string $filename): ResponseInterface
	{
		$response = $this->responseFactory->createResponse()
			->withHeader('Content-Type', 'application/csv')
			->withHeader('Content-Disposition', 'attachment; filename=' . $filename);
		$response->getBody()->write($fileContents);

		return $response;
	}
}
