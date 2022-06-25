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
use Katheroine\Layin\Console\SitePrepareCommand;

/**
 * System command preparing site directory tests.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class SitePrepareCommandTest extends TestCase
{
    private const EXEC_LOCATION = 'tests/testing_environment/command_exec_results/';

    protected function tearDown(): void
    {
        shell_exec('cd ' . self::EXEC_LOCATION . '; rm -rf site');
    }

    public function testSitePrepareCommandClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Console\SitePrepareCommand')
        );
    }

    public function testExecute()
    {
        $command = new SitePrepareCommand();
        $command->setExecLocation(self::EXEC_LOCATION);

        $command->execute();
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals('', $command->getMessage());

        $execDirectory = scandir(self::EXEC_LOCATION);
        $this->assertEquals(['.', '..', 'site'], $execDirectory);
        $siteDirectory = scandir(self::EXEC_LOCATION . '/site');
        $this->assertEquals(['.', '..', 'config', 'preconfigurations', 'public', 'templates'], $siteDirectory);
        $publicDirectory = scandir(self::EXEC_LOCATION . '/site/public');
        $this->assertEquals(['.', '..', 'assets', 'pages'], $publicDirectory);
        $assetsDirectory = scandir(self::EXEC_LOCATION . '/site/public/assets');
        $this->assertEquals(['.', '..', 'images', 'scripts', 'stylesheets'], $assetsDirectory);
    }
}
