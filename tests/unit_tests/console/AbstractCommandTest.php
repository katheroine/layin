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
 * System command tests.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class AbstractCommandTest extends TestCase
{
    private const EXEC_LOCATION = 'tests/testing_environment/command_exec_location/';

    public function testAbstractCommandClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Console\AbstractCommand')
        );
    }

    public function testProvideCommandFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Console\AbstractCommand',
                'provideCommand'
            )
        );
    }

    /**
     * @dataProvider gettersProvider
     */
    public function testGettersFunctionsExist(string $accessorName)
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Console\AbstractCommand',
                $accessorName
            )
        );
    }

    /**
     * @dataProvider gettersProvider
     */
    public function testGettersReturnNothingBeforeExecute(string $accessorName)
    {
        $command = new ConcreteCommandCausingExecProducesString();

        $result = $command->$accessorName();

        $this->assertNull($result);
    }

    public function testExecuteFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Console\AbstractCommand',
                'execute'
            )
        );
    }

    /**
     * @dataProvider concreteCommandsClassesProvider
     */
    public function testExecuteReturnsNothing(string $concreteCommandClass)
    {
        $command = new $concreteCommandClass();

        $result = $command->execute();

        $this->assertNull($result);
    }

    public function testExecuteWhenParamsAreNotString()
    {
        $params = 1024;
        $command = new ConcreteCommandCausingExecProducesString();

        $expectedErrorMessagePattern =
            '/AbstractCommand\:\:execute\(\)\: Argument \#1 \(\$params\) must be of type string, int given/';
        $this->expectError(\TypeError::class);
        $this->expectErrorMessageMatches($expectedErrorMessagePattern);

        $command->execute($params);
    }

    /**
     * @dataProvider gettersProvider
     */
    public function testGettersReturnProperTypesAfterExecute(string $getterName, string $getterReturnedType)
    {
        $command = new ConcreteCommandCausingExecProducesString();

        $command->execute();
        $result = $command->$getterName();

        $this->assertEquals($getterReturnedType, gettype($result));
    }

    public function testExecuteWhenExecProducesString()
    {
        $date = new \DateTime();
        $command = new ConcreteCommandCausingExecProducesString();

        $expectedResult = $date->format('d m Y');

        $command->execute();
        $actualResult = $command->getResult();

        $this->assertEquals($expectedResult, $actualResult);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals($expectedResult . "\n", $command->getMessage());
    }

    public function testExecuteWhenExecProducesEmptyString()
    {
        $command = new ConcreteCommandCausingExecProducesEmptyString();

        $command->execute();
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals('', $command->getMessage());
    }

    public function testExecuteWhenExecProducesErrorString()
    {
        $command = new ConcreteCommandCausingExecProducesErrorString();

        $command->execute();
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(127, $command->getCode());
        $this->assertEquals("sh: 1: kdklccbleihqfigvefcbf: not found\n", $command->getMessage());
    }

    public function testSetExecLocationFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Console\AbstractCommand',
                'setExecLocation'
            )
        );
    }

    public function testSetLocation()
    {
        $command = new ConctreteCommandListingDirContent();

        $expectedMessage = "testing_file_1.txt\ntesting_file_2.txt\ntesting_file_3.txt\n";

        $command->setExecLocation(self::EXEC_LOCATION);
        $command->execute();
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals($expectedMessage, $command->getMessage());
    }

    private function gettersProvider(): array
    {
        return [
            ['getResult', 'string'],
            ['getCode', 'integer'],
            ['getMessage', 'string'],
        ];
    }

    private function concreteCommandsClassesProvider(): array
    {
        return [
            [ConcreteCommandCausingExecProducesString::class],
            [ConcreteCommandCausingExecProducesEmptyString::class],
            [ConcreteCommandCausingExecProducesErrorString::class],
        ];
    }
}
