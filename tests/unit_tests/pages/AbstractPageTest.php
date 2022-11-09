<?php

declare(strict_types=1);

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Page;

use PHPUnit\Framework\TestCase;

/**
 * Page tests.
 *
 * @package Page
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class AbstractPageTest extends TestCase
{
    public function testAbstractPageClassExists()
    {
        $this->assertTrue(
            class_exists('Katheroine\Layin\Page\AbstractPage')
        );
    }

    public function testRenderSelfFunctionExists()
    {
        $this->assertTrue(
            method_exists(
                'Katheroine\Layin\Page\AbstractPage',
                'renderSelf'
            )
        );
    }
}
