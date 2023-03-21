<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Katheroine\Layin\Loader;

use Katheroine\Layin\Loader\ConfigLoader;

/**
 * Configured series loader.
 * Handles the series of entities of the same purpose
 * stored as configuration files.
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/katheroine/layin
 */
class ConfiguredSeriesLoader extends ConfigLoader
{
    /**
     * @throws \ValueError
     * @throws \UnexpectedValueException
     */
    public function load(): array
    {
        $series = parent::load();

        $this->validateSeries($series);

        return $series;
    }

    /**
     * @throws \UnexpectedValueException
     */
    private function validateSeries(array $series): void
    {
        $notArrayElements = array_filter($series, function ($element) {
            return (!is_array($element));
        });

        if (!empty($notArrayElements)) {
            throw new \UnexpectedValueException("File {$this->configFilePath} does not contain series.");
        }
    }
}
