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

use Katheroine\Layin\Preconfiguration\AbstractBasePreconfiguredPageRenderer;

class ContentPreconfiguredPageRenderer extends AbstractBasePreconfiguredPageRenderer
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_path' => __DIR__ . '/../../../site/templates',
            'template_subdir_path' => 'content/',
            'template_file_extension' => 'twig.html',
            'page_file_extension' => 'html',
            'site_config_path' => __DIR__ . '/../../../site/config/site_config.yaml',
            'navigation_links_config_path' => __DIR__ . '/../../../site/config/navigation_links.yaml',
            'contact_info_links_config_path' => __DIR__ . '/../../../site/config/contact_info_links.yaml',
            'base_url' => '../../index.html',
            'subpages_url' => '..',
            'assets_dir_path' => '../../site/public/assets',
            'is_debug_mode' => false,
        ];
    }
}
