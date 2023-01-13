<?php

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
 * Preconfigured page renderer for the Violet theme tests.
 *
 * @package Renderer
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
            class_exists('Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer')
        );
    }

    public function testProvidePageRendererFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer',
                'providePageRenderer'
            )
        );
    }

    public function testProvidePreconfigurationFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer',
                'providePreconfiguration'
            )
        );
    }

    public function testSetTemplateNameFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer',
                'setTemplateName'
            )
        );
    }

    public function testSetTemplateNameReturnsSelf()
    {
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRenderer();

        $result = $preconfiguredPageRenderer->setTemplateName('page');

        $this->assertSame($preconfiguredPageRenderer, $result);
    }

    public function testSetTemplatesNameWhenTemplateNameIsNotString()
    {
        $templateName = null;
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRenderer();

        $expectedErrorMessagePattern =
            '/AbstractVioletPreconfiguredPageRenderer\:\:setTemplateName\(\)\: '
            . 'Argument \#1 \(\$templateName\) must be of type string, null given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $preconfiguredPageRenderer->setTemplateName($templateName);
    }

    public function testRenderFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer',
                'render'
            )
        );
    }

    public function testRenderReturnsString()
    {
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRenderer();

        $result = $preconfiguredPageRenderer->render();

        $this->assertIsString($result);
    }

    public function testRenderFunction()
    {
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRenderer();

        $preconfiguredPageRenderer->setTemplateName('site');

        $expectedResult = "template name: site\n"
            . "templates dir path: "
            . __DIR__
            . "/concrete_preconfigured_renderer_dummies/../../../../testing_environment/templates\n"
            . "template subdir path: \n"
            . "template file extension: html\n"
            . "template params: \n"
            . "{\"title\":\"Layin\"\n"
            . "\"site_name\":\"Layin\"\n"
            . "\"description\":\"Layin - general purpose web page layout\"\n"
            . "\"keywords\":\"layin\n"
            . "layout\n"
            . "www\n"
            . "web page\"\n"
            . "\"author\":{\"name\":\"katheroine\"\n"
            . "\"email\":\"katheroine@gmail.com\"}\n"
            . "\"charset\":\"utf-8\"\n"
            . "\"language\":\"english\"\n"
            . "\"copyright_range\":2022\n"
            . "\"base_url\":\".\"\n"
            . "\"subpages_url\":\".\/subpages\"\n"
            . "\"assets_dir\":\".\/assets\"\n"
            . "\"navigation_links\":[{\"css_id\":\"home-link\"\n"
            . "\"title\":\"Home\"\n"
            . "\"url_part\":\".\"}\n"
            . "{\"css_id\":\"accessibility-info-link\"\n"
            . "\"title\":\"Accessibility\"\n"
            . "\"url_part\":\"accessibility_info.php\"}\n"
            . "{\"css_id\":\"about-submenu\"\n"
            . "\"title\":\"About\"\n"
            . "\"submenu\":[{\"title\":\"Layin repository\"\n"
            . "\"url\":\"https:\/\/github.com\/katheroine\/layin\"}\n"
            . "{\"title\":\"Layin author\"\n"
            . "\"url\":\"https:\/\/about.me\/katheroine\"}]}\n"
            . "{\"css_id\":\"contact-link\"\n"
            . "\"title\":\"Contact\"\n"
            . "\"url_id\":\"contact-info\"}]\n"
            . "\"contact_info_links\":[{\"css_id\":\"address-link\"\n"
            . "\"title\":\"address\"\n"
            . "\"value\":\"al. Wojciecha Korfantego 35\n"
            . " 40-005 Katowice\"\n"
            . "\"url\":\"https:\/\/goo.gl\/maps\/T84vfoTp8Rdbh6V28\"}\n"
            . "{\"css_id\":\"email-action\"\n"
            . "\"title\":\"e-mail\"\n"
            . "\"value\":\"layin@gmail.com\"\n"
            . "\"url\":\"mailto:layin@gmail.com\"}\n"
            . "{\"css_id\":\"phone-action\"\n"
            . "\"title\":\"tel.\"\n"
            . "\"value\":\"(32) 000 00 00\"\n"
            . "\"url\":\"tel:+4832000000\"}\n"
            . "{\"css_id\":\"fax-action\"\n"
            . "\"title\":\"fax.\"\n"
            . "\"value\":\"(32) 000 00 00\"\n"
            . "\"url\":\"fax:+48320000000\"}]\n"
            . "\"debug\":true}";

        $result = $preconfiguredPageRenderer->render();

        $this->assertEquals($expectedResult, $result);
    }

    public function testRenderWhenPreconfigurationLacksSomeEntry()
    {
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRendererWithLackingEntry();

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Preconfiguration lacks 'site_config_path' entry.");

        $preconfiguredPageRenderer->render();
    }

    public function testRenderWhenPreconfigurationHasSurplusEntry()
    {
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRendererWithSurplusEntry();

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Preconfiguration has unneeded 'title' entry.");

        $preconfiguredPageRenderer->render();
    }
}
