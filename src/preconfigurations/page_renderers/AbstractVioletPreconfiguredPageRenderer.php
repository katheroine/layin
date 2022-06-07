<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin\Preconfiguration;

use Layin\Renderer\VioletPageRenderer;

/**
 * Preconfigured page renderer for the Violet theme.
 *
 * @package Preconfiguration
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
abstract class AbstractVioletPreconfiguredPageRenderer 
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

    /**
     * Provides associative table with appropriate obligatory keys
     * corresponding with configuration options
     * and values used for the preconfiguration preparing.
     */
    abstract protected function providePreconfiguration(): array;

    public function renderPreconfiguredPage(string $template_name): void 
    {
        $pageRenderer = $this->preconfigurePageRenderer();

        $pageRenderer->setTemplateName($template_name);

        $pageRenderer->render();
    }

    /**
     * @throws \UnexpectedValueException When preconfiguration contains improper keys.
     */
    protected function preconfigurePageRenderer(): VioletPageRenderer 
    {
        $preconfiguration = $this->providePreconfiguration();

        $this->validatePreconfiguration($preconfiguration);

        $pageRenderer = new VioletPageRenderer();
        $pageRenderer
            ->setTemplatesDirAbsolutePath($preconfiguration[self::TEMPLATES_DIR_PATH_KEY])
            ->setTemplateLocalPath($preconfiguration[self::TEMPLATE_LOCAL_PATH_KEY])
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
