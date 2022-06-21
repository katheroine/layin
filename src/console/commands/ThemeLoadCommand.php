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
    public string $assetsPath = __DIR__ . '../../assets/';
    public string $templatesPath = __DIR__ . '../../templates/';

    protected function provideCommand(string $params): string
    {
        $name = $params;

        return "cd site/public/assets/images;
            ln -s " . $this->assetsPath . "images/*" . $name . "* ./;
            cd ../stylesheets; ln -s " . $this->assetsPath . "stylesheets/*." . $name . ".* ./;
            cd ../scripts; ln -s " . $this->assetsPath . "scripts/*." . $name . ".* ./;
            cd ../../../templates/; ln -s " . $this->templatesPath . "*." . $name . ".* ./";
    }
}