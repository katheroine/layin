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

namespace Katheroine\Layin\Renderer;

/**
 * Dummy renderer for testing purposes only.
 */
class ConcretePageRenderer extends AbstractPageRenderer
{
    protected function provideTemplateParams(): array
    {
        return [
            'language' => 'english',
            'description' => 'All purpose web page layout',
            'keywords' => 'layout, web page',
            'author' => [
                'name' => 'usagi',
                'email' => 'usagi@moon.com'
            ]
        ];
    }
}
