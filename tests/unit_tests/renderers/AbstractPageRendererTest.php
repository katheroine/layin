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

use PHPUnit\Framework\TestCase;

/**
 * Page renderer tests.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class AbstractPageRendererTest extends TestCase
{
    public function testAbstractPageRendererClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Renderer\AbstractPageRenderer')
        );
    }

    public function testSetTemplatesDirPathFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractPageRenderer',
                'setTemplatesDirPath'
            )
        );
    }

    public function testSetTemplatesDirPathReturnsSelf()
    {
        $pageRenderer = new ConcretePageRenderer();

        $result = $pageRenderer->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates');

        $this->assertSame($pageRenderer, $result);
    }

    public function testSetTemplatesDirPathWhenTemplateDirAbsolutePathIsNotString()
    {
        $templatesDirPath = 1024;
        $pageRenderer = new ConcretePageRenderer();

        $expectedErrorMessagePattern =
            '/AbstractPageRenderer\:\:setTemplatesDirPath\(\)\: '
            . 'Argument \#1 \(\$templatesDirPath\) must be of type string, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRenderer->setTemplatesDirPath($templatesDirPath);
    }

    public function testSetTemplateSubdirPathFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractPageRenderer',
                'setTemplateSubdirPath'
            )
        );
    }

    public function testSetTemplateSubdirPathReturnsSelf()
    {
        $pageRenderer = new ConcretePageRenderer();

        $result = $pageRenderer->setTemplateSubdirPath('subpages/');

        $this->assertSame($pageRenderer, $result);
    }

    public function testSetTemplateSubdirPathWhenTemplateSubdirPathIsNotString()
    {
        $templateSubdirPath = 1024;
        $pageRenderer = new ConcretePageRenderer();

        $expectedErrorMessagePattern =
            '/AbstractPageRenderer\:\:setTemplateSubdirPath\(\)\: '
            . 'Argument \#1 \(\$templateSubdirPath\) must be of type string, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRenderer->setTemplateSubdirPath($templateSubdirPath);
    }

    public function testSetTemplateFileExtensionFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractPageRenderer',
                'setTemplateFileExtension'
            )
        );
    }

    public function testSetTemplateFileExtensionReturnsSelf()
    {
        $pageRenderer = new ConcretePageRenderer();

        $result = $pageRenderer->setTemplateFileExtension('.html');

        $this->assertSame($pageRenderer, $result);
    }

    public function testSetTemplateFileExtensionWhenFileExtensionIsNotString()
    {
        $templateFileExtension = 1024;
        $pageRenderer = new ConcretePageRenderer();

        $expectedErrorMessagePattern =
            '/AbstractPageRenderer\:\:setTemplateFileExtension\(\)\: '
            . 'Argument \#1 \(\$templateFileExtension\) must be of type string, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRenderer->setTemplateFileExtension($templateFileExtension);
    }

    public function testSetTemplateNameFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractPageRenderer',
                'setTemplateName'
            )
        );
    }

    public function testSetTemplateNameReturnsSelf()
    {
        $pageRenderer = new ConcretePageRenderer();

        $result = $pageRenderer->SetTemplateName('page.twig.html');

        $this->assertSame($pageRenderer, $result);
    }

    public function testSetTemplateNameWhenTemplateNameIsNotString()
    {
        $templateName = 1024;
        $pageRenderer = new ConcretePageRenderer();

        $expectedErrorMessagePattern =
            '/AbstractPageRenderer\:\:setTemplateName\(\)\: '
            . 'Argument \#1 \(\$templateName\) must be of type string, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRenderer->SetTemplateName($templateName);
    }

    public function testSetTemplateParamsFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractPageRenderer',
                'setTemplateParams'
            )
        );
    }

    public function testSetTemplateParamsReturnsSelf()
    {
        $pageRenderer = new ConcretePageRenderer();

        $result = $pageRenderer->SetTemplateParams([]);

        $this->assertSame($pageRenderer, $result);
    }

    public function testSetTemplateParamsWhenTemplateNameIsNotString()
    {
        $templateParams = 1024;
        $pageRenderer = new ConcretePageRenderer();

        $expectedErrorMessagePattern =
            '/AbstractPageRenderer\:\:setTemplateParams\(\)\: '
            . 'Argument \#1 \(\$templateParams\) must be of type array, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRenderer->setTemplateParams($templateParams);
    }

    public function testRenderFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractPageRenderer',
                'render'
            )
        );
    }

    public function testRenderReturnsString()
    {
        $pageRenderer = new ConcretePageRenderer();
        $pageRenderer
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateName('page')
            ->setTemplateFileExtension('.twig.html');

        $result = $pageRenderer->render();

        $this->assertIsString($result);
    }
}
