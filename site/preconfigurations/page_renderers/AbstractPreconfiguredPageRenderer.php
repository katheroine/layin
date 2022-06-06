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

use Layin\Renderer\VioletPageRenderer;

abstract class AbstractPreconfiguredPageRenderer {
  public function renderPreconfiguredPage(string $template_name): void {
    $pageRenderer = $this->preconfigurePageRenderer();

    $pageRenderer->setTemplateName($template_name);

    $pageRenderer->render();
  }

  protected function preconfigurePageRenderer(): VioletPageRenderer {
    $preconfiguration = $this->providePreconfiguration();

    $pageRenderer = new VioletPageRenderer();
    $pageRenderer
      ->setConfigDirPath($preconfiguration['config_dir_path'])
      ->setBaseRelativeUrl($preconfiguration['base_url'])
      ->setSubpagesRelativeUrl($preconfiguration['subpages_relative_url'])
      ->setAssetsDirRelativePath($preconfiguration['assets_dir_relative_path'])
      ->setTemplatesDirAbsolutePath($preconfiguration['templates_dir_absolute_path'])
      ->setTemplateLocalPath($preconfiguration['template_local_path'])
      ->setCodeFileExtension($preconfiguration['code_file_extension'])
      ->setIsDebugMode($preconfiguration['is_debug_mode']);

    return $pageRenderer;
  }

  abstract protected function providePreconfiguration(): array;
}
