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

use Layin\AbstractPreconfiguredPageRenderer;

class LayoutsBoardPreconfiguredPageRenderer extends AbstractPreconfiguredPageRenderer {
  protected function providePreconfiguration(): array {
    return [
      'config_dir_path' => '../../../../config',
      'base_url' => '../../..',
      'subpages_relative_url' => '../../../pages',
      'assets_dir_relative_path' => '../../../assets',
      'templates_dir_absolute_path' => __DIR__ . '/../../templates',
      'template_local_path' => 'layouts/board/',
      'code_file_extension' => 'php',
      'is_debug_mode' => false,
    ];
  }
}
