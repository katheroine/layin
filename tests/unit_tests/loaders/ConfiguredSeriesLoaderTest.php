<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Loader;

use Katheroine\Layin\Loader\AbstractConfigLoaderTest;

/**
 * Configured series loader tests.
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class ConfiguredSeriesLoaderTest extends AbstractConfigLoaderTest
{
    public function testConfiguredSeriesLoaderClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Loader\ConfiguredSeriesLoader')
        );
    }

    public function testLoad()
    {
        $filePath = $this->buildFileFixturePath('configured_series.yaml');
        $loader = new ConfiguredSeriesLoader($filePath);
        $loader->setReplacements(['base_url' => '../..']);

        $result = $loader->load();

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(
            [
                [
                    'css_id' => 'home-link',
                    'title' => 'Home',
                    'url_part' => '../..',
                ],
                [
                    'css_id' => 'accessibility-info-link',
                    'title' => 'Accessibility',
                    'url_part' => 'accessibility_info.php',
                ],
                [
                    'css_id' => 'about-submenu',
                    'title' => 'About',
                    'submenu' => [
                        [
                            'title' => 'Layin repository',
                            'url' => 'https://github.com/katheroine/layin',
                        ],
                        [
                            'title' => 'Layin author',
                            'url' => 'https://about.me/katheroine',
                        ],
                    ]
                ],
                [
                    'css_id' => 'contact-link',
                    'title' => 'Contact',
                    'url_id' => 'contact-info',
                ],
            ],
            $result
        );
    }

    public function testLoadWhenResultIsNotSeries()
    {
        $filePath = $this->buildFileFixturePath('config_file.yaml');
        $loader = new ConfiguredSeriesLoader($filePath);

        $this->expectException('\UnexpectedValueException');
        $this->expectExceptionMessage('File does not contain series.');

        $result = $loader->load();
    }
}
