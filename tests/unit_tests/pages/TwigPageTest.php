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
 * Templated page tests.
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

    public function testRenderSelfFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\TwigPage',
                'renderSelf'
            )
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
                'setTemplateName'
            )
        );
    }

    public function testSetTemplateNameWithNotStringName()
    {
        $page = new TwigPage();
        $name = 1024;

        $this->expectException(\TypeError::class);

        $page->setTemplateName($name);
    }

    public function testSetTemplateNameReturnsSelf()
    {
        $page = new TwigPage();

        $result = $page->setTemplateName('name');

        $this->assertInstanceOf(TwigPage::class, $result);
    }

    public function testTemplateNamePropertyExists()
    {
        $this->assertClassHasAttribute(
            'templateName',
            'Katheroine\Layin\Page\TwigPage'
        );
    }

    public function testSetTemplateNameWorksProperly()
    {
        $page = new ConcreteTemplatedPage();

        $expected = (string) rand();
        $page->setTemplateName($expected);

        $actual = $page->getProperty('templateName');

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
}
