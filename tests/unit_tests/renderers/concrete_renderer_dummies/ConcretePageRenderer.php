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
    public function render(): string
    {
        $content = 'template name: ' . $this->templateName . "\n"
            . 'templates dir path: ' . $this->templatesDirPath . "\n"
            . 'template subdir path: ' . $this->templateSubdirPath . "\n"
            . 'template file extension: ' . $this->templateFileExtension . "\n"
            . "template params: \n" . implode("\n", explode(',', json_encode($this->templateParams)));

        return $content;
    }

    public function getProperty(string $propertyName)
    {
        return $this->$propertyName;
    }
}
