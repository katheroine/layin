<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Page;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TemplateWrapper;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use Twig\Error\RuntimeError;

/**
 * Twig page.
 * Page that handles a Twig templating system.
 *
 * @package Page
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class TwigPage extends AbstractPage
{
    protected string|null $templatesDirPath = null;
    protected string|null $templateSubdirPath = null;
    protected string|null $templateFileName = null;
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

    public function setTemplateFileName(string $templateFileName): self
    {
        $this->templateFileName = $templateFileName;

        return $this;
    }

    public function setTemplateParams(array $templateParams): self
    {
        $this->templateParams = $templateParams;

        return $this;
    }

    public function renderSelf(): string
    {
        $template = $this->loadTemplate();

        return $template->render($this->templateParams);
    }

    private function loadTemplate(): TemplateWrapper
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
            . $this->templateFileName
        );

        return $template;
    }
}
