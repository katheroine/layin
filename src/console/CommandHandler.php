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

/**
 * Command handler.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class CommandHandler
{
    private string $commandsPath = '';

    public function setCommandsPath(string $commandsPath): self
    {
        return $this;
    }

    public function handleCommand(array $commandLine): void
    {
        $command = isset($commandLine[1]) ? $commandLine[1] : '';
        $params = isset($commandLine[2]) ? $commandLine[2] : '';

        list($commandTopic, $commandAction) = explode(":", $command);

        $commandClass = 'Layin\\Console\\' . ucfirst($commandTopic) . ucfirst($commandAction) . 'Command';

        $commandInstance = new $commandClass;
        $commandInstance->execute($params);

        echo $commandInstance->getMessage();
    }
}