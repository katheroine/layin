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

/**
 * Dummy preconfigured page renderer for testing purposes only.
 */
class ConcreteVioletPreconfiguredPageRenderer extends AbstractVioletPageRendererPreconfigurator
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_absolute_path' => __DIR__ . '/../../../testing_environment/templates',
            'template_local_path' => '',
            'config_dir_path' => __DIR__ . '/../../../testing_environment/configs',
            'base_url' => '.',
            'subpages_relative_url' => './subpages',
            'assets_dir_relative_path' => './assets',
            'code_file_extension' => 'php',
            'is_debug_mode' => true,
        ];
    }
}
