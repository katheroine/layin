<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin\Console;

use PHPUnit\Framework\TestCase;

class ConcreteCommandCausingExecProducesString extends AbstractCommand
{
    protected function provideCommand(array $params): string
    {
        return 'date +"%d %m %Y";';
    }
}

class ConcreteCommandCausingExecProducesEmptyString extends AbstractCommand
{
    protected function provideCommand(array $params): string
    {
        return 'echo "" > /dev/null';
    }
}

class ConcreteCommandCausingExecProducesErrorString extends AbstractCommand
{
    protected function provideCommand(array $params): string
    {
        return 'kdklccbleihqfigvefcbf';
    }
}

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
    public function testAbstractCommandClassExists()
    {
        $this->assertTrue(
            class_exists('\Layin\Console\AbstractCommand')
        );
    }

    public function testProvideCommandFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                '\Layin\Console\AbstractCommand',
                'provideCommand'
            )
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorFunctionsExist(string $accessorName)
    {
        $this->assertTrue(
            method_exists(
                '\Layin\Console\AbstractCommand',
                $accessorName
            )
        );
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsReturnNothingBeforeExecute(string $accessorName)
    {
        $command = new ConcreteCommandCausingExecProducesString;

        $result = $command->$accessorName();

        $this->assertNull($result);
    }

    public function testExecuteFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                '\Layin\Console\AbstractCommand',
                'execute'
            )
        );
    }

    /**
     * @dataProvider concreteCommandsClassesProvider
     */
    public function testExecuteReturnsNothing(string $concreteCommandClass)
    {
        $command = new $concreteCommandClass;

        $result = $command->execute();

        $this->assertNull($result);
    }

    /**
     * @dataProvider accessorsProvider
     */
    public function testAccessorsReturnProperTypesAfterExecute(string $accessorName, string $accessorReturnedType)
    {
        $command = new ConcreteCommandCausingExecProducesString;

        $command->execute();
        $result = $command->$accessorName();

        $this->assertEquals($accessorReturnedType, gettype($result));
    }

    public function testExecuteWhenExecProducesString()
    {
        $date = new \DateTime;
        $command = new ConcreteCommandCausingExecProducesString;

        $expectedResult = $date->format('d m Y');
        $command->execute();
        $actualResult = $command->getResult();

        $this->assertEquals($expectedResult, $actualResult);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals($expectedResult . "\n", $command->getMessage());
    }

    public function testExecuteWhenExecProducesEmptyString()
    {
        $command = new ConcreteCommandCausingExecProducesEmptyString;

        $command->execute();
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(0, $command->getCode());
        $this->assertEquals('', $command->getMessage());
    }

    public function testExecuteWhenExecProducesErrorString()
    {
        $command = new ConcreteCommandCausingExecProducesErrorString;

        $command->execute();
        $result = $this->getResult();

        $this->assertEquals('', $result);
        $this->assertEquals(127, $command->getCode());
        $this->assertEquals("sh: 1: kdklccbleihqfigvefcbf: not found\n", $command->getMessage());
    }

    private function accessorsProvider(): array
    {
        return [
            ['getResult', 'string'],
            ['getCode', 'integer'],
            ['getMessage', 'string'],
        ];
    }

    private function concreteCommandsClassesProvider()
    {
        return [
            [ConcreteCommandCausingExecProducesString::class],
            [ConcreteCommandCausingExecProducesEmptyString::class],
            [ConcreteCommandCausingExecProducesErrorString::class],
        ];
    }
}