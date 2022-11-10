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

/**
 * Templated page.
 * Page that handles a templating system.
 *
 * @package Page
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
trait TemplatedPageTrait
{
    protected string $templatesDirPath;
    protected string $templateSubdirPath;
    protected string $templateName;
    protected array $templateParams;

    // abstract public function renderSelf(): string;

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
}
