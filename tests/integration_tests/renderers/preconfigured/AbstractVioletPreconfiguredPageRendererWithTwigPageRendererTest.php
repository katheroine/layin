<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Preconfigurator;

use Katheroine\Layin\Renderer\ConcreteVioletPreconfiguredPageRendererWithTwigPageRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Preconfigured page renderer for the Violet theme configured with Twing page renderer tests.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class AbstractVioletPreconfiguredPageRendererWithTwigPageRendererTest extends TestCase
{
    public function testRenderFunction()
    {
        $preconfiguredPageRenderer = new ConcreteVioletPreconfiguredPageRendererWithTwigPageRenderer();

        $preconfiguredPageRenderer->setTemplateName('violet_template');

        $expectedResult = file_get_contents(__DIR__ . '/../../../testing_environment/results/violet_rendered_page.html');

        $result = $preconfiguredPageRenderer->render();

        $this->assertEquals($expectedResult, $result);
    }
}
