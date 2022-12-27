<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Preconfiguration;

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
abstract class AbstractVioletPageRendererPreconfigurator
{
    /**
     * Preconfiguration obligatory keys.
     */
    protected const TEMPLATES_DIR_PATH_KEY = 'templates_dir_absolute_path';
    protected const TEMPLATE_LOCAL_PATH_KEY = 'template_local_path';
    protected const CONFIG_DIR_PATH_KEY = 'config_dir_path';
    protected const BASE_URL_KEY = 'base_url';
    protected const SUBPAGES_URL_KEY = 'subpages_relative_url';
    protected const ASSETS_DIR_PATH_KEY = 'assets_dir_relative_path';
    protected const CODE_FILE_EXTENSION_KEY = 'code_file_extension';
    protected const IS_DEBUG_MODE_KEY = 'is_debug_mode';

    protected AbstractPageRenderer $pageRenderer;
    protected string $assetsDirPath = '';
    protected string $templateFileExtension = '';

    /**
     * Provides associative table with appropriate obligatory keys
     * corresponding with configuration options
     * and values used for the preconfiguration preparing.
     */
    abstract protected function providePreconfiguration(): array;

    public function setPageRenderer(AbstractPageRenderer $pageRenderer): self
    {
        $this->pageRenderer = $pageRenderer;

        return $this;
    }

    public function setAssetsDirPath(string $assetsDirPath): self
    {
        return $this;
    }

    public function setSiteConfigPath(string $siteConfigPath): self
    {
        return $this;
    }

    public function setNavigationLinksConfigPath(string $navigationLinksConfigPath): self
    {
        return $this;
    }

    public function setContactInfoConfigPath(string $contactInfoConfigPath): self
    {
        return $this;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        return $this;
    }

    public function setSubpagesUrl(string $subpagesUrl): self
    {
        return $this;
    }

    public function setTemplateFileExtension(string $templateFileExtension): self
    {
        $this->templateFileExtension = $templateFileExtension;

        return $this;
    }

    public function setPageFileExtension(string $pageFileExtension): self
    {
        return $this;
    }

    public function setIsDebugMode(bool $isDebugMode): self
    {
        return $this;
    }

    public function preconfigurePageRenderer(): void
    {
        $this->pageRenderer
            ->setTemplateFileExtension($this->templateFileExtension)
            ->setTemplateParams($this->provideTemplateParams());
    }

    private function provideSiteConfig(): array
    {
        $siteConfigRelativePath = $this->configDirPath . '/site_config.yaml';

        $configLoader = new ConfigLoader($siteConfigRelativePath);
        $siteConfig = $configLoader->load();

        return $siteConfig;
    }

    private function provideNavigationLinks(): array
    {
        $navigationLinksRelativePath = $this->configDirPath . '/navigation_links.yaml';

        $navigationLinksLoader = new ConfiguredSeriesLoader($navigationLinksRelativePath);
        $navigationLinksLoader->setReplacements([
            'base_url' => $this->baseRelativeUrl,
            'code_file_extension' => $this->codeFileExtension,
        ]);
        $navigationLinks = $navigationLinksLoader->load();

        return $navigationLinks;
    }

    private function provideContactInfoLinks(): array
    {
        $contactInfoLinksRelativePath = $this->configDirPath . '/contact_info_links.yaml';

        $contactInfoLinksLoader = new ConfiguredSeriesLoader($contactInfoLinksRelativePath);
        $contactInfoLinks = $contactInfoLinksLoader->load();

        return $contactInfoLinks;
    }

    protected function provideTemplateParams(): array
    {
        $templateParams = array_merge(
            $this->provideSiteConfig(),
            [
                'subpages_url' => $this->subpagesRelativeUrl,
                'assets_dir' => $this->assetsDirRelativePath,
                'navigation_links' => $this->provideNavigationLinks(),
                'contact_info_links' => $this->provideContactInfoLinks(),
                'debug' => $this->isDebugMode,
            ]
        );

        return $templateParams;
    }

    public function renderPreconfiguredPage(string $template_name): void
    {
        $pageRenderer = $this->prepreconfigurePageRenderer();

        $pageRenderer->setTemplateName($template_name);

        $pageRenderer->render();
    }

    /**
     * @throws \UnexpectedValueException When preconfiguration contains improper keys.
     */
    protected function prepreconfigurePageRenderer(): VioletPageRenderer
    {
        $preconfiguration = $this->providePreconfiguration();

        $this->validatePreconfiguration($preconfiguration);

        $pageRenderer = new VioletPageRenderer();
        $pageRenderer
            ->setTemplatesDirPath($preconfiguration[self::TEMPLATES_DIR_PATH_KEY])
            ->setTemplateSubdirPath($preconfiguration[self::TEMPLATE_LOCAL_PATH_KEY])
            ->setConfigDirPath($preconfiguration[self::CONFIG_DIR_PATH_KEY])
            ->setBaseRelativeUrl($preconfiguration[self::BASE_URL_KEY])
            ->setSubpagesRelativeUrl($preconfiguration[self::SUBPAGES_URL_KEY])
            ->setAssetsDirRelativePath($preconfiguration[self::ASSETS_DIR_PATH_KEY])
            ->setCodeFileExtension($preconfiguration[self::CODE_FILE_EXTENSION_KEY])
            ->setIsDebugMode($preconfiguration[self::IS_DEBUG_MODE_KEY]);

        return $pageRenderer;
    }

    /**
     * @throws \UnexpectedValueException When preconfiguration contains improper keys.
     */
    private function validatePreconfiguration(array $preconfiguration): void
    {
        $preconfigurationKeys = $this->providePreconfigurationKeys();

        $this->detectLackingPreconfigurationKeys($preconfiguration);
        $this->detectUnneededPreconfigurationKeys($preconfiguration);
    }

    /**
     * @throws \UnexpectedValueException When preconfiguration lacks some keys.
     */
    private function detectLackingPreconfigurationKeys(array $preconfiguration): void
    {
        $preconfigurationKeys = $this->providePreconfigurationKeys();

        foreach ($preconfigurationKeys as $key) {
            if (! array_key_exists($key, $preconfiguration)) {
                throw new \UnexpectedValueException("Preconfiguration lacks '$key' entry.");
            }
        }
    }

    /**
     * @throws \UnexpectedValueException When preconfiguration has some unneeded keys.
     */
    private function detectUnneededPreconfigurationKeys(array $preconfiguration): void
    {
        $preconfigurationKeys = $this->providePreconfigurationKeys();

        foreach ($preconfiguration as $key => $value) {
            if (! in_array($key, $preconfigurationKeys)) {
                throw new \UnexpectedValueException("Preconfiguration has unneeded '$key' entry.");
            }
        }
    }

    private function providePreconfigurationKeys(): array
    {
        return [
            self::TEMPLATES_DIR_PATH_KEY,
            self::TEMPLATE_LOCAL_PATH_KEY,
            self::CONFIG_DIR_PATH_KEY,
            self::BASE_URL_KEY,
            self::SUBPAGES_URL_KEY,
            self::ASSETS_DIR_PATH_KEY,
            self::CODE_FILE_EXTENSION_KEY,
            self::IS_DEBUG_MODE_KEY,
        ];
    }
}
