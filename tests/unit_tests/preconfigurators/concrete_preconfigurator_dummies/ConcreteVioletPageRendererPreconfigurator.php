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

namespace Katheroine\Layin\Preconfigurator;

/**
 * Dummy renderer configurator for testing purposes only.
 */
class ConcreteVioletPageRendererPreconfigurator extends AbstractVioletPageRendererPreconfigurator
{
    public function providePreconfiguration(): array
    {
        return [];
    }
}
