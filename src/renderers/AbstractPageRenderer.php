<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin\Renderer;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TemplateWrapper;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;
use Layin\ConfigLoader;
use Layin\PreconfiguredSeriesLoader;

/**
 * Page renderer.
 *
 * @package Renderer
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
abstract class AbstractPageRenderer
{
    private string $templatesDirAbsolutePath = '';
    private string $templateLocalPath = '';
    private string $templateName = '';

    abstract protected function provideTemplateParams(): array;

    public function setTemplatesDirAbsolutePath(string $templatesDirAbsolutePath): self
    {
        $this->templatesDirAbsolutePath = $templatesDirAbsolutePath;

        return $this;
    }

    public function setTemplateLocalPath(string $templateLocalPath): self
    {
        $this->templateLocalPath = $templateLocalPath;

        return $this;
    }

    public function setTemplateName(string $templateName): self
    {
        $this->templateName = $templateName;

        return $this;
    }

    /**
     * @throws LoaderError When the template cannot be found
     * @throws SyntaxError When an error occurred during compilation
     * @throws RuntimeError When an error occurred during rendering
     */
    public function render()
    {
        $template = $this->loadTemplate();
        echo $template->render($this->provideTemplateParams());
    }

    private function loadTemplate(): TemplateWrapper
    {
        $loader = new FilesystemLoader($this->templatesDirAbsolutePath);
        $environment = new Environment($loader);

        /**
         * @throws LoaderError When the template cannot be found
         * @throws SyntaxError When an error occurred during compilation
         * @throws RuntimeError When an error occurred during rendering
         */
        $template = $environment->load(
            $this->templateLocalPath
            . $this->templateName
        );

        return $template;
    }
}
