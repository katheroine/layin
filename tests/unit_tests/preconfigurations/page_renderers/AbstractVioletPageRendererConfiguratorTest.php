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

use Exception;
use Katheroine\Layin\Renderer\ConcretePageRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Page renderer configurator for the Violet theme tests.
 *
 * @package Preconfiguration
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class AbstractVioletPageRendererConfiguratorTest extends TestCase
{
    public function testAbstractVioletPageRendererConfiguratorClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Preconfiguration\AbstractVioletPageRendererConfigurator')
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorFunctionsExist(string $accessorName)
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Preconfiguration\AbstractVioletPageRendererConfigurator',
                $accessorName
            )
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsReturnSelf(string $accessorName, string $accessorAgrumentType)
    {
        $pageRendererConfigurator = new ConcreteVioletPageRendererConfigurator();

        $result = $pageRendererConfigurator->$accessorName($this->provideValueForType($accessorAgrumentType));

        $this->assertSame($pageRendererConfigurator, $result);
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsWhenItsArgumentsHaveWrongTypes(
        string $accessorName,
        string $accessorAgrumentType,
        string $accessorArgumentName
    ) {
        $argumentValue = null;
        $pageRendererConfigurator = new ConcreteVioletPageRendererConfigurator();

        $expectedErrorMessagePattern =
            '/AbstractVioletPageRendererConfigurator\:\:' . $accessorName . '\(\)\: '
            . 'Argument \#1 \(\$' . $accessorArgumentName
            . '\) must be of type ' . $accessorAgrumentType . ', null given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRendererConfigurator->$accessorName($argumentValue);
    }

    public function testConfigurePageRendererFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Preconfiguration\AbstractVioletPageRendererConfigurator',
                'configurePageRenderer'
            )
        );
    }

    public function testRenderPreconfiguredPageFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Preconfiguration\AbstractVioletPageRendererConfigurator',
                'renderPreconfiguredPage'
            )
        );
    }

    public function testRenderPreconfiguredPageReturnsNothing()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRenderer();

        ob_start(); // Doesn't allow to echo rendered template.
        $result = $pageRenderer->renderPreconfiguredPage('page.twig.html');
        ob_end_clean();

        $this->assertNull($result);
    }

    public function testRenderPreconfiguredPageWhenPreconfigurationLacksSomeEntry()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRendererWithLackingEntry();

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Preconfiguration lacks 'config_dir_path' entry.");

        $pageRenderer->renderPreconfiguredPage('page.twig.html');
    }

    public function testRenderPreconfiguredPageWhenPreconfigurationHasSurplusEntry()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRendererWithSurplusEntry();

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Preconfiguration has unneeded 'title' entry.");

        $pageRenderer->renderPreconfiguredPage('page.twig.html');
    }

    public function testRenderPreconfiguredPage()
    {
        $pageRenderer = new ConcreteVioletPreconfiguredPageRenderer();

        ob_start(); // Doesn't allow to echo rendered template.
        $pageRenderer->renderPreconfiguredPage('violet_template.twig.html');
        $actualRenderedContent = ob_get_contents();
        ob_end_clean();

        $expectedRenderedContent = file_get_contents(
            __DIR__ . '/../../../testing_environment/results/violet_rendered_page.html'
        );

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }

    protected function accessorsProvider(): array
    {
        return [
            ['setPageRenderer', 'Katheroine\\\Layin\\\Renderer\\\AbstractPageRenderer', 'pageRenderer'],
            ['setAssetsDirPath', 'string', 'assetsDirPath'],
            ['setSiteConfigPath', 'string', 'siteConfigPath'],
            ['setNavigationLinksConfigPath', 'string', 'navigationLinksConfigPath'],
            ['setContactInfoConfigPath', 'string', 'contactInfoConfigPath'],
            ['setBaseUrl', 'string', 'baseUrl'],
            ['setSubpagesUrl', 'string', 'subpagesUrl'],
            ['setTemplateFileExtension', 'string', 'templateFileExtension'],
            ['setPageFileExtension', 'string', 'pageFileExtension'],
            ['setIsDebugMode', 'bool', 'isDebugMode'],
        ];
    }

    private function provideValueForType(string $typeName)
    {
        switch ($typeName) {
            case 'string':
                return 'abc';
            case 'bool':
                return false;
            case 'Katheroine\\\Layin\\\Renderer\\\AbstractPageRenderer':
                return new ConcretePageRenderer();
        }
    }
}
