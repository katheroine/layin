<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Preconfiguration;

class IndexPreconfiguredPageRenderer extends AbstractBasePreconfiguredPageRenderer
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_path' => __DIR__ . '/../../templates',
            'template_subdir_path' => '',
            'template_file_extension' => 'twig.html',
            'page_file_extension' => 'php',
            'site_config_path' => '../../config/site_config.yaml',
            'navigation_links_config_path' => '../../config/navigation_links.yaml',
            'contact_info_links_config_path' => '../../config/contact_info_links.yaml',
            'base_url' => '.',
            'subpages_url' => 'pages',
            'assets_dir_path' => '../assets',
            'is_debug_mode' => false,
        ];
    }
}
