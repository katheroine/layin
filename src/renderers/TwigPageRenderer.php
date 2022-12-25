<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Renderer;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TemplateWrapper;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;

/**
 * Twig page renderer.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class TwigPageRenderer extends AbstractPageRenderer
{
    /**
     * @throws LoaderError When the template cannot be found
     * @throws SyntaxError When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function render()
    {
        $template = $this->loadTemplate();

        return $template->render($this->templateParams);
    }

    protected function loadTemplate(): TemplateWrapper
    {
        $loader = new FilesystemLoader($this->templatesDirPath);
        $environment = new Environment($loader);

        /**
         * @throws LoaderError When the template cannot be found
         * @throws SyntaxError When an error occurred during compilation
         * @throws RuntimeError When an error occurred during rendering
         */
        $template = $environment->load(
            $this->templateSubdirPath
            . $this->templateName
            . $this->templateFileExtension
        );

        return $template;
    }
}
