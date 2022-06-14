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
 * linking theme files to appropriate site subdirectories.
 *
 * @package Console
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class ThemeLoadCommand extends AbstractCommand
{
    public string $assetsPath = '../../../../src/assets/';

    protected function provideCommand(array $params): string
    {
        return "cd site/public/assets/images;
            ln -s " . $this->assetsPath . "images/*" . $params['name'] . "* ./;
            cd ../stylesheets; ln -s " . $this->assetsPath . "stylesheets/*." . $params['name'] . ".* ./
            cd ../scripts; ln -s " . $this->assetsPath . "scripts/*." . $params['name'] . ".* ./";
    }
}