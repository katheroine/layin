<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin\Preconfiguration;

use PHPUnit\Framework\TestCase;

class ConcreteVioletPreconfiguredPageRenderer extends AbstractVioletPreconfiguredPageRenderer
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

class ConcreteVioletPreconfiguredPageRendererWithLackingEntry extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_absolute_path' => __DIR__ . '/../../testing_environment/templates',
            'template_local_path' => '',
            'base_url' => '.',
            'subpages_relative_url' => './subpages',
            'assets_dir_relative_path' => './assets',
            'code_file_extension' => 'php',
            'is_debug_mode' => true,
        ];
    }
}

class ConcreteVioletPreconfiguredPageRendererWithSurplusEntry extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePreconfiguration(): array
    {
        return [
            'templates_dir_absolute_path' => __DIR__ . '/../../testing_environment/templates',
            'template_local_path' => '',
            'config_dir_path' => __DIR__ . '/../../testing_environment/configs',
            'base_url' => '.',
            'title' => '',
            'subpages_relative_url' => './subpages',
            'assets_dir_relative_path' => './assets',
            'code_file_extension' => 'php',
            'is_debug_mode' => true,
        ];
    }
}

/**
 * Preconfigured page renderer for the Violet theme tests.
 *
 * @package Preconfiguration
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class AbstractVioletPreconfiguredPageRendererTest extends TestCase
{
    public function testAbstractVioletPreconfiguredPageRendererClassExists()
    {
        $this->assertTrue(
            class_exists('\Layin\Preconfiguration\AbstractVioletPreconfiguredPageRenderer')
        );
    }

    public function testRenderPreconfiguredPageFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Layin\Preconfiguration\AbstractVioletPreconfiguredPageRenderer',
                'renderPreconfiguredPage'
            )
        );
    }

    public function testRenderPreconfiguredPageReturnsNothing()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRenderer;

        ob_start(); // Doesn't allow to echo rendered template.
        $result = $pageRenderer->renderPreconfiguredPage('page.twig.html');
        ob_end_clean();

        $this->assertNull($result);
    }

    public function testRenderPreconfiguredPageWhenPreconfigurationLacksSomeEntry()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRendererWithLackingEntry;

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Preconfiguration lacks 'config_dir_path' entry.");

        $pageRenderer->renderPreconfiguredPage('page.twig.html');
    }

    public function testRenderPreconfiguredPageWhenPreconfigurationHasSurplusEntry()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRendererWithSurplusEntry;

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Preconfiguration has unneeded 'title' entry.");

        $pageRenderer->renderPreconfiguredPage('page.twig.html');
    }

    public function testRenderPreconfiguredPage()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRenderer;

        ob_start(); // Doesn't allow to echo rendered template.
        $pageRenderer->renderPreconfiguredPage('violet_template.twig.html');
        $actualRenderedContent = ob_get_contents();
        ob_end_clean();

        $expectedRenderedContent = file_get_contents(
            __DIR__ . '/../../../testing_environment/results/violet_rendered_page.html'
        );

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }
}