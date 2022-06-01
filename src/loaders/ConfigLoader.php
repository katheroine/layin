<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin\Loader;

use \Symfony\Component\Yaml\Yaml;

/**
 * Config loader.
 * Handles the source and type of the stored configuration
 * and loads it.
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
class ConfigLoader
{
    private string $configFilePath;
    private array $replacements = [];

    /**
     * @throws \ValueError
     */
    public function __construct(string $configFilePath)
    {
        $this->validateConfigFilePath($configFilePath);

        $this->configFilePath = $configFilePath;
    }

    public function setReplacements(array $replacements): void
    {
        $this->replacements = $replacements;
    }

    /**
     * @throws \ValueError
     */
    public function load(): array
    {
        $configContent = file_get_contents($this->configFilePath);

        $configContentWithReplacements = $this->introduceReplacementsIntoConfigContent($configContent);
        $config = $this->parseConfigContent($configContentWithReplacements);

        return $config;
    }

    /**
     * @throws \ValueError
     */
    private function validateConfigFilePath(string $configFilePath): void
    {
        if (!file_exists($configFilePath)) {
          throw new \ValueError('File given by path does not exist.');
        }
    }

    private function introduceReplacementsIntoConfigContent(string $configContent): string
    {
        list($to_replace, $replace_with) = $this->prepareReplacements();

        $configContentWithReplacements = str_replace(
          $to_replace,
          $replace_with,
          $configContent
        );

        return $configContentWithReplacements;
    }

    private function parseConfigContent(string $configContent): array
    {
        $configContentParsed = Yaml::parse($configContent);
        $config = (empty($configContentParsed)) ? [] : $configContentParsed;

        return $config;
    }

    private function prepareReplacements(): array
    {
        $to_replace = array_keys($this->replacements);
        array_walk($to_replace, function(&$value, $key) {
            $value = "[[$value]]";
        });

        $replace_with = array_values($this->replacements);

        return [$to_replace, $replace_with];
    }
}
