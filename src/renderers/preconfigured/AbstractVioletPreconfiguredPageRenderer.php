<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Renderer;

use Katheroine\Layin\Preconfigurator\VioletPageRendererPreconfigurator;

/**
 * Preconfigured page renderer for the Violet theme.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
abstract class AbstractVioletPreconfiguredPageRenderer
{
    /**
     * Preconfiguration obligatory keys.
     */
    protected const TEMPLATES_DIR_PATH_KEY = 'templates_dir_path';
    protected const TEMPLATE_SUBDIR_PATH_KEY = 'template_subdir_path';
    protected const TEMPLATE_FILE_EXTENSION_KEY = 'template_file_extension';
    protected const PAGE_FILE_EXTENSION_KEY = 'page_file_extension';
    protected const SITE_CONFIG_PATH_KEY = 'site_config_path';
    protected const NAVIGATION_LINKS_CONFIG_PATH_KEY = 'navigation_links_config_path';
    protected const CONTACT_INFO_LINKS_CONFIG_PATH_KEY = 'contact_info_links_config_path';
    protected const ASSETS_DIR_PATH_KEY = 'assets_dir_path';
    protected const BASE_URL_KEY = 'base_url';
    protected const SUBPAGES_URL_KEY = 'subpages_url';
    protected const IS_DEBUG_MODE_KEY = 'is_debug_mode';

    protected AbstractPageRenderer $pageRenderer;
    protected VioletPageRendererPreconfigurator $pageRendererPreconfigurator;
    protected array $preconfiguration = [];

    abstract protected function providePageRenderer(): AbstractPageRenderer;

    /**
     * Provides associative table with appropriate obligatory keys
     * corresponding with configuration options
     * and values used for the preconfiguration preparing.
     */
    abstract protected function providePreconfiguration(): array;

    public function __construct()
    {
        $this->pageRendererPreconfigurator = new VioletPageRendererPreconfigurator();
        $this->pageRenderer = $this->providePageRenderer();

        $this->pageRendererPreconfigurator->setPageRenderer($this->pageRenderer);
    }

    public function setTemplateName(string $templateName): self
    {
        $this->pageRenderer->setTemplateName($templateName);

        return $this;
    }

    public function render()
    {
        $preconfiguration = $this->providePreconfiguration();
        $this->validatePreconfiguration($preconfiguration);

        $this->pageRendererPreconfigurator
            ->setTemplatesDirPath($preconfiguration[self::TEMPLATES_DIR_PATH_KEY])
            ->setTemplateSubdirPath($preconfiguration[self::TEMPLATE_SUBDIR_PATH_KEY])
            ->setTemplateFileExtension($preconfiguration[self::TEMPLATE_FILE_EXTENSION_KEY])
            ->setPageFileExtension($preconfiguration[self::PAGE_FILE_EXTENSION_KEY])
            ->setSiteConfigPath($preconfiguration[self::SITE_CONFIG_PATH_KEY])
            ->setNavigationLinksConfigPath($preconfiguration[self::NAVIGATION_LINKS_CONFIG_PATH_KEY])
            ->setContactInfoLinksConfigPath($preconfiguration[self::CONTACT_INFO_LINKS_CONFIG_PATH_KEY])
            ->setAssetsDirPath($preconfiguration[self::ASSETS_DIR_PATH_KEY])
            ->setBaseUrl($preconfiguration[self::BASE_URL_KEY])
            ->setSubpagesUrl($preconfiguration[self::SUBPAGES_URL_KEY])
            ->setIsDebugMode($preconfiguration[self::IS_DEBUG_MODE_KEY]);

        $this->pageRendererPreconfigurator->preconfigurePageRenderer();

        $content = $this->pageRenderer->render();

        return $content;
    }

    /**
     * @throws \UnexpectedValueException When preconfiguration contains improper keys.
     */
    private function validatePreconfiguration(array $preconfiguration): void
    {
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
            self::TEMPLATE_SUBDIR_PATH_KEY,
            self::TEMPLATE_FILE_EXTENSION_KEY,
            self::PAGE_FILE_EXTENSION_KEY,
            self::SITE_CONFIG_PATH_KEY,
            self::NAVIGATION_LINKS_CONFIG_PATH_KEY,
            self::CONTACT_INFO_LINKS_CONFIG_PATH_KEY,
            self::ASSETS_DIR_PATH_KEY,
            self::BASE_URL_KEY,
            self::SUBPAGES_URL_KEY,
            self::IS_DEBUG_MODE_KEY,
        ];
    }
}
