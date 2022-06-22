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

namespace Katheroine\Layin\Console;

use PHPUnit\Framework\TestCase;

/**
 * Command handler tests.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class CommandHandlerTest extends TestCase
{
    public function testCommandHandlerClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Console\CommandHandler')
        );
    }

    public function testHandleCommandFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Console\CommandHandler',
                'handleCommand'
            )
        );
    }

    public function testHandleCommandPathReturnsNothing()
    {
        $commandHandler = new CommandHandler();

        ob_start();
        $result = $commandHandler->handleCommand(['./bin/invokation_script.php', 'directory:list', 'argument']);
        ob_end_clean();

        $this->assertNull($result);
    }

    public function testHandleCommandWhenCommandLineIsNotArray()
    {
        $commandLine = 1024;
        $commandHandler = new CommandHandler();

        $expectedErrorMessagePattern =
            '/CommandHandler\:\:handleCommand\(\)\: '
            . 'Argument \#1 \(\$commandLine\) must be of type array, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $commandHandler->handleCommand($commandLine);
    }

    /**
     * @dataProvider commandsProvider
     */
    public function testHandleCommand(string $commandName, string $commandParams, string $commandClass)
    {
        $fullCommandClass = '\\Katheroine\\Layin\\Console\\' . $commandClass;
        $expectedCommand = new $fullCommandClass();
        $expectedCommand->setExecLocation('tests/testing_environment/command_exec_location/');

        ob_start();
        $expectedCommand->execute($commandParams);
        $expectedOutput = $expectedCommand->getMessage();
        ob_end_clean();

        $commandHandler = new CommandHandler();

        $commandLine = [
            './bin/invokation_script.php',
            $commandName,
            $commandParams
        ];

        ob_start();
        $commandHandler->handleCommand($commandLine);
        $actualOutput = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($expectedOutput, $actualOutput);
    }

    private function commandsProvider(): array
    {
        return [
            ['directory:list', '', 'DirectoryListCommand'],
            ['date:display', '%Y %m %d', 'DateDisplayCommand'],
            ['date:display', '%y-%m-%d %H:%m:%S', 'DateDisplayCommand'],
        ];
    }
}
