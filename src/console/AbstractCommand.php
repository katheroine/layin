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

    private string|null $result = null;
    private int|null $code = null;
    private string|null $message = null;

    /**
     * Provides content of the system command
     * as it would be written in the console.
     */
    abstract protected function provideCommand(array $params): string;

    /**
     * @throws \RuntimeException When command encounters problem or system command fails
     */
    public function execute(array $params = []): void
    {
        $command = $this->provideCommand($params);

        ob_start();
        $command = $command . " 2>&1";
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
}