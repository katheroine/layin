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

namespace Katheroine\Layin\Page;

use PHPUnit\Framework\TestCase;

/**
 * Twig page tests.
 *
 * @package Page
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class TwigPageTest extends TestCase
{
    public function testAbstractPageClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Page\TwigPage')
        );
    }

    // Templates Directory Path

    public function testSetTemplatesDirPathFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\TwigPage',
                'setTemplatesDirPath'
            )
        );
    }

    public function testSetTemplatesDirPathWithNotStringPath()
    {
        $page = new TwigPage();
        $path = 1024;

        $this->expectException(\TypeError::class);

        $page->setTemplatesDirPath($path);
    }

    public function testSetTemplatesDirPathReturnsSelf()
    {
        $page = new TwigPage();

        $result = $page->setTemplatesDirPath('directory/');

        $this->assertInstanceOf(TwigPage::class, $result);
    }

    public function testTemplatesDirPathPropertyExists()
    {
        $this->assertClassHasAttribute(
            'templatesDirPath',
            'Katheroine\Layin\Page\TwigPage'
        );
    }

    public function testSetTemplatesDirPathWorksProperly()
    {
        $page = new ConcreteTemplatedPage();

        $expected = (string) rand();
        $page->setTemplatesDirPath($expected);

        $actual = $page->getProperty('templatesDirPath');

        $this->assertEquals($expected, $actual);
    }

    // Template Subdirectory Path

    public function testSetTemplateSubdirPathFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\TwigPage',
                'setTemplateSubdirPath'
            )
        );
    }

    public function testSetTemplateSubdirPathWithNotStringPath()
    {
        $page = new TwigPage();
        $path = 1024;

        $this->expectException(\TypeError::class);

        $page->setTemplateSubdirPath($path);
    }

    public function testSetTemplateSubdirPathReturnsSelf()
    {
        $page = new TwigPage();

        $result = $page->setTemplateSubdirPath('subdirectory/');

        $this->assertInstanceOf(TwigPage::class, $result);
    }

    public function testTemplateSubirPathPropertyExists()
    {
        $this->assertClassHasAttribute(
            'templateSubdirPath',
            'Katheroine\Layin\Page\TwigPage'
        );
    }

    public function testSetTemplateSubdirPathWorksProperly()
    {
        $page = new ConcreteTemplatedPage();

        $expected = (string) rand();
        $page->setTemplateSubdirPath($expected);

        $actual = $page->getProperty('templateSubdirPath');

        $this->assertEquals($expected, $actual);
    }

    // Template Name

    public function testSetTemplateNameFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\TwigPage',
                'setTemplateFileName'
            )
        );
    }

    public function testSetTemplateNameWithNotStringName()
    {
        $page = new TwigPage();
        $name = 1024;

        $this->expectException(\TypeError::class);

        $page->setTemplateFileName($name);
    }

    public function testSetTemplateNameReturnsSelf()
    {
        $page = new TwigPage();

        $result = $page->setTemplateFileName('name');

        $this->assertInstanceOf(TwigPage::class, $result);
    }

    public function testTemplateNamePropertyExists()
    {
        $this->assertClassHasAttribute(
            'templateFileName',
            'Katheroine\Layin\Page\TwigPage'
        );
    }

    public function testSetTemplateFileNameWorksProperly()
    {
        $page = new ConcreteTemplatedPage();

        $expected = (string) rand();
        $page->setTemplateFileName($expected);

        $actual = $page->getProperty('templateFileName');

        $this->assertEquals($expected, $actual);
    }

    // Template Parameters

    public function testSetTemplateParamsFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\TwigPage',
                'setTemplateParams'
            )
        );
    }

    public function testSetTemplateParamsWithNotArrayParams()
    {
        $page = new TwigPage();
        $params = 1024;

        $this->expectException(\TypeError::class);

        $page->setTemplateParams($params);
    }

    public function testSetTemplateParamsReturnsSelf()
    {
        $page = new TwigPage();

        $result = $page->setTemplateParams([]);

        $this->assertInstanceOf(TwigPage::class, $result);
    }

    public function testTemplateParamsPropertyExists()
    {
        $this->assertClassHasAttribute(
            'templateParams',
            'Katheroine\Layin\Page\ConcreteTemplatedPage'
        );
    }

    public function testSetTemplateParamsWorksProperly()
    {
        $page = new ConcreteTemplatedPage();

        $expected = [(string) rand()];
        $page->setTemplateParams($expected);

        $actual = $page->getProperty('templateParams');

        $this->assertEquals($expected, $actual);
    }

    // Render self

    public function testRenderSelfFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\TwigPage',
                'renderSelf'
            )
        );
    }

    public function testRenderSelfReturnsEmptyStringWhenTemplateIsEmpty()
    {
        $page = new TwigPage();
        $page
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileName('empty_page.twig.html');

        $result = $page->renderSelf();

        $this->assertEquals('', $result);
    }

    public function testRenderSelfWhenNoTemplateIsSet()
    {
        $page = new TwigPage();

        // Twig doc: When the template cannot be found
        $this->expectException(\Twig\Error\LoaderError::class);
        $this->expectExceptionMessage('There are no registered paths for namespace "__main__".');

        $page->renderSelf();
    }

    public function testRenderSelfWhenTemplateContentIsSyntacticallyImproper()
    {
        $page = new TwigPage();
        $page
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileName('syntactically_improper_content.twig.html');

        // Twig doc: When an error occurred during compilation.
        $this->expectException(\Twig\Error\SyntaxError::class);
        $this->expectExceptionMessage('Unexpected "}"');

        $page->renderSelf();
    }

    public function testRenderSelfWithoutTemplateParams()
    {
        $page = new TwigPage();
        $page
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileName('page.twig.html');

        $actualRenderedContent = $page->renderSelf();

        $expectedRenderedContent = "<!doctype html>\n"
            . "<html lang=\"en-GB\">\n"
            . "  <head>\n"
            . "    <meta charset=\"\">\n"
            . "    <meta name=\"language\" content=\"\">\n"
            . "    <meta name=\"description\" content=\"\">\n"
            . "    <meta name=\"keywords\" content=\"\">\n"
            . "    <meta name=\"author\" content=\" <>\">\n"
            . "  </head>\n"
            . "  <body>\n"
            . "    <h1>Welcome on the home page!</h1>\n"
            . "  </body>\n"
            . "</html>\n";

        $this->assertEquals($expectedRenderedContent, $actualRenderedContent);
    }

    public function testRenderSelfWitTemplateParams()
    {
        $page = new TwigPage();
        $page
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileName('page.twig.html')
            ->setTemplateParams([
                'language' => 'english',
                'description' => 'All purpose web page layout',
                'keywords' => 'layout, web page',
                'author' => [
                    'name' => 'usagi',
                    'email' => 'usagi@moon.com',
                ],
            ]);

        $actualRenderedContent = $page->renderSelf();

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

    public function testRenderSelfWithoutTemplateSubdirectoryPath()
    {
        $page = new TwigPage();
        $page
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateFileName('page.twig.html')
            ->setTemplateParams([
                'language' => 'english',
                'description' => 'All purpose web page layout',
                'keywords' => 'layout, web page',
                'author' => [
                    'name' => 'usagi',
                    'email' => 'usagi@moon.com',
                ],
            ]);

        $actualRenderedContent = $page->renderSelf();

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

    public function testRenderSelfWithTemplateSubdirPath()
    {
        $page = new TwigPage();
        $page
            ->setTemplatesDirPath(__DIR__ . '/../../testing_environment/templates')
            ->setTemplateSubdirPath('subpages/')
            ->setTemplateFileName('subpage.twig.html')
            ->setTemplateParams([
                'language' => 'english',
                'description' => 'All purpose web page layout',
                'keywords' => 'layout, web page',
                'author' => [
                    'name' => 'usagi',
                    'email' => 'usagi@moon.com',
                ],
            ]);

        $actualRenderedContent = $page->renderSelf();

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
}
