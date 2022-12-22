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
use Katheroine\Layin\ConfigLoader;
use Katheroine\Layin\PreconfiguredSeriesLoader;

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
    private string $templatesDirPath = '';
    private string $templateSubdirPath = '';
    private string $templateFileExtension = '';
    private string $templateName = '';
    protected array $templateParams = [];

    public function setTemplatesDirPath(string $templatesDirPath): self
    {
        $this->templatesDirPath = $templatesDirPath;

        return $this;
    }

    public function setTemplateSubdirPath(string $templateSubdirPath): self
    {
        $this->templateSubdirPath = $templateSubdirPath;

        return $this;
    }

    public function setTemplateFileExtension(string $templateFileExtension): self
    {
        $this->templateFileExtension = $templateFileExtension;

        return $this;
    }

    public function setTemplateName(string $templateName): self
    {
        $this->templateName = $templateName;

        return $this;
    }

    public function setTemplateParams(array $templateParams): self
    {
        $this->templateParams = $templateParams;

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
