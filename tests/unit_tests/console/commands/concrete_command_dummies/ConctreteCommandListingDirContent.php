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
 * Dummy command for testing purposes only.
 */
class ConctreteCommandListingDirContent extends AbstractCommand
{
    protected function provideCommand(string $params): string
    {
        return 'ls';
    }
}
