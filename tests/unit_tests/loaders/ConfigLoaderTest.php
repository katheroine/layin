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

namespace Layin\Loader;

use Layin\Loader\AbstractConfigLoaderTest;

/**
 * Config loader tests.
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class ConfigLoaderTest extends AbstractConfigLoaderTest
{
    /**
     * Relative path of directory with file fixtures
     * used in tests.
     */
    private const FILE_FIXTURES_RELATIVE_PATH = '../../testing_environment/config_sources';

    public function testConfigLoaderClassExists()
    {
        $this->assertTrue(
            class_exists('\Layin\Loader\ConfigLoader')
        );
    }

    public function testConstructorWhenFilePathIsNotString()
    {
        $filePath = 1024;

        $expectedErrorMessagePattern =
            '/ConfigLoader\:\:__construct\(\)\: Argument \#1 \(\$configFilePath\) must be of type string, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $loader = new ConfigLoader($filePath);
    }

    public function testConstructorWhenConfigFileDoesNotExist()
    {
        $filePath = $this->buildFileFixturePath('nonexistent');

        $this->expectException('\ValueError');
        $this->expectExceptionMessage('File given by path does not exist.');

        $loader = new ConfigLoader($filePath);
    }

    public function testConstructorWhenConfigFileExists()
    {
        $filePath = $this->buildFileFixturePath('config_file.yaml');

        $loader = new ConfigLoader($filePath);

        $this->assertInstanceOf(\Layin\Loader\ConfigLoader::class, $loader);
    }

    public function testLoadFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Layin\Loader\ConfigLoader',
                'load'
            )
        );
    }

    public function testLoadReturnsArray()
    {
        $filePath = $this->buildFileFixturePath('config_file.yaml');
        $loader = new ConfigLoader($filePath);

        $result = $loader->load();

        $this->assertIsArray($result);
    }

    public function testLoadWhenConfigFileIsEmpty()
    {
        $filePath = $this->buildFileFixturePath('empty_config_file.yaml');
        $loader = new ConfigLoader($filePath);

        $result = $loader->load();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testLoadYamlFile()
    {
        $filePath = $this->buildFileFixturePath('config_file.yaml');
        $loader = new ConfigLoader($filePath);

        $result = $loader->load();

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
          'copyright_range' => '2022',
        ],
        $result);
    }

    public function testLoadJsonFile()
    {
        $filePath = $this->buildFileFixturePath('config_file.json');
        $loader = new ConfigLoader($filePath);

        $result = $loader->load();

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
          'copyright_range' => '2022',
        ],
        $result);
    }

    public function testSetReplacementsFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Layin\Loader\ConfigLoader',
                'setReplacements'
            )
        );
    }

    public function testSetReplacementsReturnsNothing()
    {
        $filePath = $this->buildFileFixturePath('config_file.yaml');
        $loader = new ConfigLoader($filePath);

        $result = $loader->setReplacements([]);

        $this->assertNull($result);
    }

    public function testSetReplacementsWhenReplacementsAreNotArray()
    {
        $filePath = $this->buildFileFixturePath('config_file.json');
        $loader = new ConfigLoader($filePath);

        $replacements = 1024;

        $expectedErrorMessagePattern =
            '/ConfigLoader\:\:setReplacements\(\)\: Argument \#1 \(\$replacements\) must be of type array, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $loader->setReplacements($replacements);
    }

    public function testLoadWorksWithReplacements()
    {
        $filePath = $this->buildFileFixturePath('config_file_with_placeholders.yaml');
        $loader = new ConfigLoader($filePath);

        $loader->setReplacements([
            'project_name' => 'Layin',
            'developer_nickname' => 'katheroine'
        ]);

        $result = $loader->load();

        $this->assertEquals([
          'title' => 'Layin',
          'site_name' => 'Layin',
          'description' => 'Layin - general purpose web page layout',
          'keywords' => 'Layin,layout,www,web page',
          'author' => [
            'name' => 'katheroine',
            'email' => 'katheroine@gmail.com',
          ],
          'charset' => 'utf-8',
          'language' => 'english',
          'copyright_range' => '2022',
        ],
        $result);
    }
}
