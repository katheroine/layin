<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Demo;

use Katheroine\Layin\Preconfiguration\AbstractVioletPreconfiguredPageRenderer;

class IndexPreconfiguredPageRenderer extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_absolute_path' => __DIR__ . '/../../../site/templates',
            'template_local_path' => '',
            'config_dir_path' => __DIR__ . '/../../../site/config',
            'base_url' => '../index.html',
            'subpages_relative_url' => 'demo',
            'assets_dir_relative_path' => 'site/public/assets',
            'code_file_extension' => 'html',
            'is_debug_mode' => false,
        ];
    }
}
