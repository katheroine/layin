<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin\Loader;

use PHPUnit\Framework\TestCase;

/**
 * Config loaders tests base.
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
abstract class AbstractConfigLoaderTest extends TestCase
{
    /**
     * Relative path of directory with file fixtures
     * used in tests.
     */
    private const FILE_FIXTURES_RELATIVE_PATH = '../../testing_environment/config_sources';

    protected function buildFileFixturePath($fileName): string
    {
        $absoluteFilePath = __DIR__
            . DIRECTORY_SEPARATOR
            . self::FILE_FIXTURES_RELATIVE_PATH
            . DIRECTORY_SEPARATOR
            . $fileName;

        return $absoluteFilePath;
    }
}
