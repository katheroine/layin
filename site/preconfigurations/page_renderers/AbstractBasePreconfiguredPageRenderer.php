<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Preconfiguration;

use Katheroine\Layin\Renderer\AbstractPageRenderer;
use Katheroine\Layin\Renderer\AbstractVioletPreconfiguredPageRenderer;
use Katheroine\Layin\Renderer\TwigPageRenderer;

abstract class AbstractBasePreconfiguredPageRenderer extends AbstractVioletPreconfiguredPageRenderer
{
    protected function providePageRenderer(): AbstractPageRenderer
    {
        return new TwigPageRenderer();
    }

    abstract protected function providePreconfiguration(): array;
}
