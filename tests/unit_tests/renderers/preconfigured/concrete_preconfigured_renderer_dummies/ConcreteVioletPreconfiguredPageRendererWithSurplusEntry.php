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

/**
 * Dummy preconfigured page renderer for testing purposes only.
 */
class ConcreteVioletPreconfiguredPageRendererWithSurplusEntry extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePageRenderer(): AbstractPageRenderer
    {
        return new ConcretePageRenderer();
    }

    protected function providePreconfiguration(): array
    {
        $relative_path = '/../../../../';

        return [
            'templates_dir_path' => __DIR__ . $relative_path . 'testing_environment/templates',
            'template_subdir_path' => '',
            'template_file_extension' => 'html',
            'page_file_extension' => 'php',
            'site_config_path' => __DIR__ . $relative_path . 'testing_environment/configs/site_config.yaml',
            'title' => 'Layin',
            'navigation_links_config_path' => __DIR__ . $relative_path . 'testing_environment/configs/navigation_links.yaml',
            'contact_info_links_config_path' => __DIR__ . $relative_path . 'testing_environment/configs/contact_info_links.yaml',
            'base_url' => '.',
            'subpages_url' => './subpages',
            'assets_dir_path' => './assets',
            'is_debug_mode' => true,
        ];
    }
}
