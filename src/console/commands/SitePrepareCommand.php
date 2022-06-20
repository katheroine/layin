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
 * System command
 * preparing site directory with appropriate subdirectories.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class SitePrepareCommand extends AbstractCommand
{
    protected function provideCommand(string $params): string
    {
        return "mkdir site;
            cd site; mkdir config preconfigurations public templates;
            cd public; mkdir assets pages;
            cd assets; mkdir images stylesheets scripts";
        }
}