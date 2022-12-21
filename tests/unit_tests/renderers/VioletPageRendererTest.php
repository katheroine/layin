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

namespace Katheroine\Layin\Loader;

use PHPUnit\Framework\TestCase;
use Katheroine\Layin\Renderer\VioletPageRenderer;

/**
 * Violet page renderer tests.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class VioletPageRendererTest extends TestCase
{
    public function testVioletPageRendererClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Renderer\VioletPageRenderer')
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorFunctionsExist(string $accessorName)
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\VioletPageRenderer',
                $accessorName
            )
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsReturnSelf(string $accessorName, string $accessorAgrumentType)
    {
        $pageRenderer = new VioletPageRenderer();

        $result = $pageRenderer->$accessorName($this->provideValueForType($accessorAgrumentType));

        $this->assertInstanceOf(VioletPageRenderer::class, $result);
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsWhenItsArgumentsHaveWrongTypes(
        string $accessorName,
        string $accessorAgrumentType,
        string $accessorArgumentName
    ) {
        $argumentValue = 1024;
        $pageRenderer = new VioletPageRenderer();

        $expectedErrorMessagePattern =
            '/VioletPageRenderer\:\:' . $accessorName . '\(\)\: '
            . 'Argument \#1 \(\$' . $accessorArgumentName
            . '\) must be of type ' . $accessorAgrumentType . ', int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRenderer->$accessorName($argumentValue);
    }

    public function testRender()
    {
        $pageRenderer = new VioletPageRenderer();
        $pageRenderer
            ->setBaseRelativeUrl('.')
            ->setSubpagesRelativeUrl('./subpages')
            ->setConfigDirPath(__DIR__ . '/../../testing_environment/configs')
            ->setAssetsDirRelativePath('./assets')
            ->setCodeFileExtension('php')
            ->setIsDebugMode(true)
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateName('violet_template.twig.html');

        ob_start(); // Allow to capture rendered content instead of echoing it.
        $pageRenderer->render();
        $actualRenderedContent = ob_get_contents();
        ob_end_clean();

        $expectedRenderedContent = file_get_contents(__DIR__ . '/../../testing_environment/results/violet_rendered_page.html');

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }

    protected function accessorsProvider(): array
    {
        return [
            ['setConfigDirPath', 'string', 'configDirPath'],
            ['setBaseRelativeUrl', 'string', 'baseRelativeUrl'],
            ['setSubpagesRelativeUrl', 'string', 'subpagesRelativeUrl'],
            ['setAssetsDirRelativePath', 'string', 'assetsDirRelativePath'],
            ['setCodeFileExtension', 'string', 'codeFileExtension'],
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
        }
    }
}
