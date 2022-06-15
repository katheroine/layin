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
 * System command for the testing purposes.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class DateDisplayCommand extends AbstractCommand
{
    protected string|null $execLocation = 'tests/testing_environment/command_exec_location/';

    protected function provideCommand(string $params): string
    {
        $format = trim($params);

        return "date +'$params'";
    }
}