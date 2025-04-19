<?php

declare(strict_types=1);

/*
 * This file is part of the "Redirects Export" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace RKL\RedirectsExport\Redirects\EventListener;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Redirects\Event\ModifyRedirectManagementControllerViewDataEvent;

final class ModifyRedirectManagementControllerViewDataEventListener
{
	public function __construct(
		protected UriBuilder $uriBuilder,
		protected IconFactory $iconFactory
	) {}

	public function __invoke(ModifyRedirectManagementControllerViewDataEvent $event): void
	{
		$view = $event->getView();
		if (!($view instanceof ModuleTemplate)) {
			return;
		}

		$buttonBar = $view->getDocHeaderComponent()->getButtonBar();

		// create button to export redirects route
		$exportRedirectsButton = $buttonBar->makeLinkButton()
			->setHref((string)$this->uriBuilder->buildUriFromRoute('export_redirects'))
			->setTitle($this->getTranslatedLabel('LLL:EXT:redirects_export/Resources/Private/Language/locallang.xlf:exportRedirects'))
			->setShowLabelText(true)
			->setIcon($this->iconFactory->getIcon('actions-download', Icon::SIZE_SMALL));

		// add button to button bar
		$buttonBar->addButton($exportRedirectsButton, ButtonBar::BUTTON_POSITION_RIGHT, 0);
	}

	private function getTranslatedLabel(string $key): string
	{
		$languageServiceFactory = GeneralUtility::makeInstance(LanguageServiceFactory::class);
		$userPreference = ($GLOBALS['BE_USER'] instanceof AbstractUserAuthentication) ? $GLOBALS['BE_USER'] : null;
		$languageService = $languageServiceFactory->createFromUserPreferences($userPreference);
		return $languageService->sL($key);
	}
}
