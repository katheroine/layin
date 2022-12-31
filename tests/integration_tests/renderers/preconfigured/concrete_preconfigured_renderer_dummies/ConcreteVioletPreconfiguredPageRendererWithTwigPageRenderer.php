<?php

declare(strict_types=1);

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Renderer;

/**
 * Dummy renderer for testing purposes only.
 */
class ConcreteVioletPreconfiguredPageRendererWithTwigPageRenderer extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePageRenderer(): AbstractPageRenderer
    {
        return new TwigPageRenderer();
    }

    protected function providePreconfiguration(): array
    {
        $relativePath = '/../../../../';

        return [
            'templates_dir_path' => __DIR__ . $relativePath . 'testing_environment/templates',
            'template_subdir_path' => '',
            'template_file_extension' => 'twig.html',
            'page_file_extension' => 'php',
            'site_config_path' => __DIR__ . $relativePath . 'testing_environment/configs/site_config.yaml',
            'navigation_links_config_path' => __DIR__ . $relativePath . 'testing_environment/configs/navigation_links.yaml',
            'contact_info_links_config_path' => __DIR__ . $relativePath . 'testing_environment/configs/contact_info_links.yaml',
            'base_url' => '.',
            'subpages_url' => './subpages',
            'assets_dir_path' => './assets',
            'is_debug_mode' => true,
        ];
    }
}
