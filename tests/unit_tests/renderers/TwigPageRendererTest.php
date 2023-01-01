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
 * Twig page renderer tests.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class TwigPageRendererTest extends TestCase
{
    public function testTwigPageRendererClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Renderer\TwigPageRenderer')
        );
    }

    public function testRenderFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\TwigPageRenderer',
                'render'
            )
        );
    }

    public function testRenderReturnsString()
    {
        $pageRenderer = new ConcretePageRenderer();
        $pageRenderer
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileExtension('twig.html')
            ->setTemplateName('page');

        $result = $pageRenderer->render();

        $this->assertIsString($result);
    }

    public function testRenderWhenNoTemplateIsSet()
    {
        $pageRenderer = new TwigPageRenderer();

        // Twig doc: When the template cannot be found
        $this->expectException(\Twig\Error\LoaderError::class);
        $this->expectExceptionMessage('There are no registered paths for namespace "__main__".');

        $pageRenderer->render();
    }

    public function testRenderWhenTemplateContentIsSyntacticallyImproper()
    {
        $pageRenderer = new TwigPageRenderer();
        $pageRenderer
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileExtension('twig.html')
            ->setTemplateName('syntactically_improper_content');

        // Twig doc: When an error occurred during compilation.
        $this->expectException(\Twig\Error\SyntaxError::class);
        $this->expectExceptionMessage('Unexpected "}"');

        $pageRenderer->render();
    }

    public function testRenderWhenTemplateContentIsEmpty()
    {
        $pageRenderer = new TwigPageRenderer();
        $pageRenderer
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileExtension('twig.html')
            ->setTemplateName('empty_page');

        $actualRenderedContent = $pageRenderer->render();

        $expectedRenderedContent = "";

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }

    public function testRenderWithoutTemplateSubdirPath()
    {
        $pageRenderer = new TwigPageRenderer();
        $pageRenderer
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileExtension('twig.html')
            ->SetTemplateName('page')
            ->setTemplateParams($this->provideTemplateParams());

        $actualRenderedContent = $pageRenderer->render();

        $expectedRenderedContent = "<!doctype html>\n"
            . "<html lang=\"en-GB\">\n"
            . "  <head>\n"
            . "    <meta charset=\"\">\n"
            . "    <meta name=\"language\" content=\"english\">\n"
            . "    <meta name=\"description\" content=\"All purpose web page layout\">\n"
            . "    <meta name=\"keywords\" content=\"layout, web page\">\n"
            . "    <meta name=\"author\" content=\"usagi <usagi@moon.com>\">\n"
            . "  </head>\n"
            . "  <body>\n"
            . "    <h1>Welcome on the home page!</h1>\n"
            . "  </body>\n"
            . "</html>\n";

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }

    public function testRenderWithTemplateSubdirPath()
    {
        $pageRenderer = new TwigPageRenderer();
        $pageRenderer
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateSubdirPath('subpages/')
            ->setTemplateFileExtension('twig.html')
            ->SetTemplateName('subpage')
            ->setTemplateParams($this->provideTemplateParams());

        $actualRenderedContent = $pageRenderer->render();

        $expectedRenderedContent = "<!doctype html>\n"
            . "<html lang=\"en-GB\">\n"
            . "  <head>\n"
            . "    <meta charset=\"\">\n"
            . "    <meta name=\"language\" content=\"english\">\n"
            . "    <meta name=\"description\" content=\"All purpose web page layout\">\n"
            . "    <meta name=\"keywords\" content=\"layout, web page\">\n"
            . "    <meta name=\"author\" content=\"usagi <usagi@moon.com>\">\n"
            . "  </head>\n"
            . "  <body>\n"
            . "    <h1>Welcome on the subpage!</h1>\n"
            . "  </body>\n"
            . "</html>\n";

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }

    private function provideTemplateParams(): array
    {
        return [
            'language' => 'english',
            'description' => 'All purpose web page layout',
            'keywords' => 'layout, web page',
            'author' => [
                'name' => 'usagi',
                'email' => 'usagi@moon.com'
            ]
        ];
    }
}
