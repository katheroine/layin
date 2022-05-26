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
abstract class PageRenderer
{
  private string $templatesDirAbsolutePath;
  private string $templateName;

  public function setTemplatesDirAbsolutePath(string $templatesDirAbsolutePath): self {
    $this->templatesDirAbsolutePath = $templatesDirAbsolutePath;
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

  abstract protected function provideTemplateParams(): array;
}
