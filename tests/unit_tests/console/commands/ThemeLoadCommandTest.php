<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Console;

use PHPUnit\Framework\TestCase;
use Katheroine\Layin\Console\ThemeLoadCommand;

/**
 * System command linking theme files to appropriate site subdirectories tests.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class ThemeLoadCommandTest extends TestCase
{
    private const EXEC_LOCATION = 'tests/testing_environment/command_exec_results/';
    private const ASSETS_PATH = __DIR__ . '/../../../testing_environment/theme/assets/';
    private const TEMPLATES_PATH = __DIR__ . '/../../../testing_environment/theme/templates/';

    protected function setUp(): void
    {
        shell_exec('cd ' . self::EXEC_LOCATION . '; mkdir site;
            cd site; mkdir config preconfigurations public templates;
            cd public; mkdir assets pages;
            cd assets; mkdir images stylesheets scripts');
    }

    protected function tearDown(): void
    {
        shell_exec('cd ' . self::EXEC_LOCATION . '; rm -rf site');
    }

    public function testThemeLoadCommandClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Console\ThemeLoadCommand')
        );
    }

    public function testExecute()
    {
        $command = new ThemeLoadCommand();
        $command->setExecLocation(self::EXEC_LOCATION);

        $command->assetsPath = self::ASSETS_PATH;
        $command->templatesPath = self::TEMPLATES_PATH;
        $command->execute('orchid');
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals('', $command->getMessage());

        $imagesDirectory = scandir(self::EXEC_LOCATION . 'site/public/assets/images');
        $this->assertEquals(['.', '..', 'icons.orchid'], $imagesDirectory);
        $stylesheetsDirectory = scandir(self::EXEC_LOCATION . 'site/public/assets/stylesheets');
        $this->assertEquals(['.', '..', 'content.orchid.css', 'site.orchid.css'], $stylesheetsDirectory);
        $scriptsDirectory = scandir(self::EXEC_LOCATION . 'site/public/assets/scripts');
        $this->assertEquals(['.', '..', 'accessibility.orchid.js', 'dashboard.orchid.js'], $scriptsDirectory);
        $templatesDirectory = scandir(self::EXEC_LOCATION . 'site/templates');
        $this->assertEquals(['.', '..', 'index.orchid.twig.html'], $templatesDirectory);
    }
}
