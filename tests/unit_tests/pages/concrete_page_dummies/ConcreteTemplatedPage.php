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

/**
 * Dummy renderer for testing purposes only.
 */
class ConcreteTemplatedPage extends TwigPage
{
    public function renderSelf(): string
    {
        return '';
    }

    public function getProperty(string $propertyName)
    {
        return $this->$propertyName;
    }
}
