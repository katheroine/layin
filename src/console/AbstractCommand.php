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

/**
 * System command.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
abstract class AbstractCommand
{
    protected const COMMANDS_DIR_PATH = __DIR__ . "/commands/";

    protected string|null $execLocation = '';

    private string|null $result = null;
    private int|null $code = null;
    private string|null $message = null;

    /**
     * Provides content of the system command
     * as it would be written in the console.
     */
    abstract protected function provideCommand(string $params): string;

    public function setExecLocation(string $execLocation): self
    {
        $this->execLocation = $execLocation;

        return $this;
    }

    public function execute(string $params = ''): void
    {
        $command = $this->prepareCommand($params);

        ob_start();
        $this->result = system($command, $this->code);
        $this->message = ob_get_contents();
        ob_end_clean();
    }

    public function getResult(): string|null
    {
        return $this->result;
    }

    public function getCode(): int|null
    {
        return $this->code;
    }

    public function getMessage(): string|null
    {
        return $this->message;
    }

    private function prepareCommand(string $params): string
    {
        $command = '';
        if (!empty($this->execLocation)) {
            $command = "cd $this->execLocation; "; 
        }
        $command .= $this->provideCommand($params);
        $command .= " 2>&1";

        return $command;
    }
}