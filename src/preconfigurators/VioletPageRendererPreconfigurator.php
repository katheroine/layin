<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Preconfigurator;

use Katheroine\Layin\Renderer\AbstractPageRenderer;
use Katheroine\Layin\Loader\ConfigLoader;
use Katheroine\Layin\Loader\ConfiguredSeriesLoader;
use Katheroine\Layin\Renderer\VioletPageRenderer;

/**
 * Page renderer configurator for the Violet theme.
 *
 * @package Preconfiguration
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class VioletPageRendererPreconfigurator
{
    protected AbstractPageRenderer $pageRenderer;

    protected string $templatesDirPath = '';
    protected string $templateSubdirPath = '';
    protected string $templateFileExtension = '';
    protected string $pageFileExtension = '';
    protected string $siteConfigPath = '';
    protected string $navigationLinksConfigPath = '';
    protected string $contactInfoLinksConfigPath = '';
    protected string $assetsDirPath = '';
    protected string $baseUrl = '';
    protected string $subpagesUrl = '';
    protected bool $isDebugMode = false;

    /**
     * Provides associative table with appropriate obligatory keys
     * corresponding with configuration options
     * and values used for the preconfiguration preparing.
     */
    protected function providePreconfiguration(): array
    {
        return [];
    }

    public function setPageRenderer(AbstractPageRenderer $pageRenderer): self
    {
        $this->pageRenderer = $pageRenderer;

        return $this;
    }

    public function setTemplatesDirPath(string $templatesDirPath): self
    {
        $this->templatesDirPath = $templatesDirPath;

        return $this;
    }

    public function setTemplateSubdirPath(string $templateSubdirPath): self
    {
        $this->templateSubdirPath = $templateSubdirPath;

        return $this;
    }

    public function setTemplateFileExtension(string $templateFileExtension): self
    {
        $this->templateFileExtension = $templateFileExtension;

        return $this;
    }

    public function setPageFileExtension(string $pageFileExtension): self
    {
        $this->pageFileExtension = $pageFileExtension;

        return $this;
    }

    public function setSiteConfigPath(string $siteConfigPath): self
    {
        $this->siteConfigPath = $siteConfigPath;

        return $this;
    }

    public function setNavigationLinksConfigPath(string $navigationLinksConfigPath): self
    {
        $this->navigationLinksConfigPath = $navigationLinksConfigPath;

        return $this;
    }

    public function setContactInfoLinksConfigPath(string $contactInfoLinksConfigPath): self
    {
        $this->contactInfoLinksConfigPath = $contactInfoLinksConfigPath;

        return $this;
    }

    public function setAssetsDirPath(string $assetsDirPath): self
    {
        $this->assetsDirPath = $assetsDirPath;

        return $this;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function setSubpagesUrl(string $subpagesUrl): self
    {
        $this->subpagesUrl = $subpagesUrl;

        return $this;
    }

    public function setIsDebugMode(bool $isDebugMode): self
    {
        $this->isDebugMode = $isDebugMode;

        return $this;
    }

    public function preconfigurePageRenderer(): void
    {
        $this->pageRenderer
            ->setTemplatesDirPath($this->templatesDirPath)
            ->setTemplateSubdirPath($this->templateSubdirPath)
            ->setTemplateFileExtension($this->templateFileExtension)
            ->setTemplateParams($this->provideTemplateParams());
    }

    private function provideSiteConfig(): array
    {
        $siteConfigRelativePath = $this->siteConfigPath;

        $configLoader = new ConfigLoader($siteConfigRelativePath);
        $siteConfig = $configLoader->load();

        return $siteConfig;
    }

    private function provideNavigationLinks(): array
    {
        $navigationLinksRelativePath = $this->navigationLinksConfigPath;

        $navigationLinksLoader = new ConfiguredSeriesLoader($navigationLinksRelativePath);
        $navigationLinksLoader->setReplacements([
            'base_url' => $this->baseUrl,
            'code_file_extension' => $this->pageFileExtension,
        ]);
        $navigationLinks = $navigationLinksLoader->load();

        return $navigationLinks;
    }

    private function provideContactInfoLinks(): array
    {
        $contactInfoLinksRelativePath = $this->contactInfoLinksConfigPath;

        $contactInfoLinksLoader = new ConfiguredSeriesLoader($contactInfoLinksRelativePath);
        $contactInfoLinks = $contactInfoLinksLoader->load();

        return $contactInfoLinks;
    }

    protected function provideTemplateParams(): array
    {
        $templateParams = array_merge(
            $this->provideSiteConfig(),
            [
                'subpages_url' => $this->subpagesUrl,
                'assets_dir' => $this->assetsDirPath,
                'navigation_links' => $this->provideNavigationLinks(),
                'contact_info_links' => $this->provideContactInfoLinks(),
                'debug' => $this->isDebugMode,
            ]
        );

        return $templateParams;
    }
}
