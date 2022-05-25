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
use Layin\ConfigLoader;
use Layin\PreconfiguredSeriesLoader;

/**
 * PageRenderer
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
class PageRenderer
{
  private string $baseRelativeUrl;
  private string $subpagesRelativeUrl;
  private string $configDirRelativePath;
  private string $assetsDirRelativePath;
  private string $templatesDirAbsolutePath;
  private string $codeFileExtension;
  private bool $isDebugMode;
  private string $templateName;

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

  public function setTemplatesDirAbsolutePath(string $templatesDirAbsolutePath): self {
    $this->templatesDirAbsolutePath = $templatesDirAbsolutePath;
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

  public function setTemplateName(string $templateName): self {
    $this->templateName = $templateName;
    return $this;
  }

  public function render(): void {
    $loader = new FilesystemLoader($this->templatesDirAbsolutePath);
    $environment = new Environment($loader, ['debug' => true]);
    $template = $environment->load($this->templateName);
    
    echo $template->render($this->provideTemplateParams());
  }

  private function provideSiteConfig(): array {
    $siteConfigRelativePath = $this->configDirRelativePath . '/site_config.yaml';

    $siteConfig = ConfigLoader::load($siteConfigRelativePath);

    return $siteConfig;
  }

  private function provideNavigationLinks(): array {
    $navigationLinksRelativePath = $this->configDirRelativePath . '/navigation_links.yaml';

    $navigationLinksLoader = new PreconfiguredSeriesLoader($navigationLinksRelativePath);
    $navigationLinksLoader->setReplacements([
      'base_url' => $this->baseRelativeUrl,
      'code_file_extension' => $this->codeFileExtension,
    ]);
    $navigationLinks = $navigationLinksLoader->load();

    return $navigationLinks;
  }

  private function provideContactInfoLinks(): array {
    $contactInfoLinksRelativePath = $this->configDirRelativePath . '/contact_info_links.yaml';

    $contactInfoLinksLoader = new PreconfiguredSeriesLoader($contactInfoLinksRelativePath);
    $contactInfoLinks = $contactInfoLinksLoader->load();

    return $contactInfoLinks;
  }

  private function provideTemplateParams(): array {
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
