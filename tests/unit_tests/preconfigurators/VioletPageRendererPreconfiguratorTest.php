<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Preconfigurator;

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
class VioletPageRendererPreconfiguratorTest extends TestCase
{
    public function testVioletPageRendererPreconfiguratorClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Preconfigurator\VioletPageRendererPreconfigurator')
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorFunctionsExist(string $accessorName)
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Preconfigurator\VioletPageRendererPreconfigurator',
                $accessorName
            )
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsReturnSelf(string $accessorName, string $accessorAgrumentType)
    {
        $pageRendererPreconfigurator = new ConcreteVioletPageRendererPreconfigurator();

        $result = $pageRendererPreconfigurator->$accessorName($this->provideValueForType($accessorAgrumentType));

        $this->assertSame($pageRendererPreconfigurator, $result);
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
        $pageRendererPreconfigurator = new ConcreteVioletPageRendererPreconfigurator();

        $expectedErrorMessagePattern =
            '/VioletPageRendererPreconfigurator\:\:' . $accessorName . '\(\)\: '
            . 'Argument \#1 \(\$' . $accessorArgumentName
            . '\) must be of type ' . $accessorAgrumentType . ', null given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $pageRendererPreconfigurator->$accessorName($argumentValue);
    }

    public function testPreconfigurePageRendererFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Preconfigurator\VioletPageRendererPreconfigurator',
                'preconfigurePageRenderer'
            )
        );
    }

    public function testPreconfigurePageRendererFunction()
    {
        $pageRenderer = new ConcretePageRenderer();
        $pageRendererPreconfigurator = new ConcreteVioletPageRendererPreconfigurator();

        $pageRendererPreconfigurator->setPageRenderer($pageRenderer);

        $templatesDirPath = __DIR__ . '/../testing_environment/templates';
        $templateSubdirPath = 'subpages';
        $templateFileExtension = 'html';
        $pageFileExtension = 'php';
        $siteConfigPath = __DIR__ . '/../../testing_environment/configs/site_config.yaml';
        $navigationLinksConfigPath = __DIR__ . '/../../testing_environment/configs/navigation_links.yaml';
        $contactInfoLinksConfigPath = __DIR__ . '/../../testing_environment/configs/contact_info_links.yaml';
        $assetsDirPath = './assets';
        $baseUrl = '.';
        $subpagesUrl = './subpages';
        $isDebugMode = true;

        $pageRendererPreconfigurator
            ->setTemplatesDirPath($templatesDirPath)
            ->setTemplateSubdirPath($templateSubdirPath)
            ->setTemplateFileExtension($templateFileExtension)
            ->setPageFileExtension($pageFileExtension)
            ->setSiteConfigPath($siteConfigPath)
            ->setNavigationLinksConfigPath($navigationLinksConfigPath)
            ->setContactInfoLinksConfigPath($contactInfoLinksConfigPath)
            ->setAssetsDirPath($assetsDirPath)
            ->setBaseUrl($baseUrl)
            ->setSubpagesUrl($subpagesUrl)
            ->setIsDebugMode($isDebugMode);

        $pageRendererPreconfigurator->preconfigurePageRenderer();

        $this->assertEquals($templatesDirPath, $pageRenderer->getProperty('templatesDirPath'));
        $this->assertEquals($templateSubdirPath, $pageRenderer->getProperty('templateSubdirPath'));
        $this->assertEquals($templateFileExtension, $pageRenderer->getProperty('templateFileExtension'));
        $this->assertEquals([
            'title' => 'Layin',
            'site_name' => 'Layin',
            'description' => 'Layin - general purpose web page layout',
            'keywords' => 'layin,layout,www,web page',
            'author' => [
                'name' => 'katheroine',
                'email' => 'katheroine@gmail.com',
            ],
            'charset' => 'utf-8',
            'language' => 'english',
            'copyright_range' => 2022,
            'subpages_url' => './subpages',
            'assets_dir' => './assets',
            'navigation_links' => [
                [
                    'css_id' => 'home-link',
                    'title' => 'Home',
                    'url_part' => '.',
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
                    ],

                ],
                [
                    'css_id' => 'contact-link',
                    'title' => 'Contact',
                    'url_id' => 'contact-info',

                ],
            ],
            'contact_info_links' => [
                [
                    'css_id' => 'address-link',
                    'title' => 'address',
                    'value' => 'al. Wojciecha Korfantego 35, 40-005 Katowice',
                    'url' => 'https://goo.gl/maps/T84vfoTp8Rdbh6V28',
                ],
                [
                    'css_id' => 'email-action',
                    'title' => 'e-mail',
                    'value' => 'layin@gmail.com',
                    'url' => 'mailto:layin@gmail.com',
                ],
                [
                    'css_id' => 'phone-action',
                    'title' => 'tel.',
                    'value' => '(32) 000 00 00',
                    'url' => 'tel:+4832000000',
                ],
                [
                    'css_id' => 'fax-action',
                    'title' => 'fax.',
                    'value' => '(32) 000 00 00',
                    'url' => 'fax:+48320000000',
                ],
            ],
            'debug' => true,

        ], $pageRenderer->getProperty('templateParams'));
    }

    protected function accessorsProvider(): array
    {
        return [
            ['setPageRenderer', 'Katheroine\\\Layin\\\Renderer\\\AbstractPageRenderer', 'pageRenderer'],
            ['setTemplatesDirPath', 'string', 'templatesDirPath'],
            ['setTemplateSubdirPath', 'string', 'templateSubdirPath'],
            ['setTemplateFileExtension', 'string', 'templateFileExtension'],
            ['setPageFileExtension', 'string', 'pageFileExtension'],
            ['setSiteConfigPath', 'string', 'siteConfigPath'],
            ['setNavigationLinksConfigPath', 'string', 'navigationLinksConfigPath'],
            ['setContactInfoLinksConfigPath', 'string', 'contactInfoLinksConfigPath'],
            ['setAssetsDirPath', 'string', 'assetsDirPath'],
            ['setBaseUrl', 'string', 'baseUrl'],
            ['setSubpagesUrl', 'string', 'subpagesUrl'],
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
