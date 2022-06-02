<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Symfony\Component\Yaml\Yaml;
use Layin\Loader\ConfigLoader;
use Layin\Loader\ConfiguredSeriesLoader;
use Layin\PageRenderer;

/**
 * PageRenderer
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
class VioletPageRenderer extends PageRenderer
{
  private string $baseRelativeUrl;
  private string $subpagesRelativeUrl;
  private string $configDirRelativePath;
  private string $assetsDirRelativePath;
  private string $codeFileExtension;
  private bool $isDebugMode;

  public function setBaseRelativeUrl(string $baseRelativeUrl): self {
    $this->baseRelativeUrl = $baseRelativeUrl;
    return $this;
  }

  public function setSubpagesRelativeUrl(string $subpagesRelativeUrl): self {
    $this->subpagesRelativeUrl = $subpagesRelativeUrl;
    return $this;
  }

  public function setConfigDirRelativePath(string $configDirRelativePath): self {
    $this->configDirRelativePath = $configDirRelativePath;
    return $this;
  }

  public function setAssetsDirRelativePath(string $assetsDirRelativePath): self {
    $this->assetsDirRelativePath = $assetsDirRelativePath;
    return $this;
  }

  public function setCodeFileExtension(string $codeFileExtension): self {
    $this->codeFileExtension = $codeFileExtension;
    return $this;
  }

  public function setIsDebugMode(bool $isDebugMode): self {
    $this->isDebugMode = $isDebugMode;
    return $this;
  }

  private function provideSiteConfig(): array {
    $siteConfigRelativePath = $this->configDirRelativePath . '/site_config.yaml';

    $configLoader = new ConfigLoader($siteConfigRelativePath);
    $siteConfig = $configLoader->load();

    return $siteConfig;
  }

  private function provideNavigationLinks(): array {
    $navigationLinksRelativePath = $this->configDirRelativePath . '/navigation_links.yaml';

    $navigationLinksLoader = new ConfiguredSeriesLoader($navigationLinksRelativePath);
    $navigationLinksLoader->setReplacements([
      'base_url' => $this->baseRelativeUrl,
      'code_file_extension' => $this->codeFileExtension,
    ]);
    $navigationLinks = $navigationLinksLoader->load();

    return $navigationLinks;
  }

  private function provideContactInfoLinks(): array {
    $contactInfoLinksRelativePath = $this->configDirRelativePath . '/contact_info_links.yaml';

    $contactInfoLinksLoader = new ConfiguredSeriesLoader($contactInfoLinksRelativePath);
    $contactInfoLinks = $contactInfoLinksLoader->load();

    return $contactInfoLinks;
  }

  protected function provideTemplateParams(): array {
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
}
