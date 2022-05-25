<?php

/*
 * This file is part of the Layin package.
 *
 * (c) Katarzyna Krasińska <katheroine@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Layin;

use \Symfony\Component\Yaml\Yaml;

/**
 * Preconfigured series loader
 *
 * @package Loader
 * @author Katarzyna Krasińska <katheroine@gmail.com>
 * @copyright Copyright (c) 2022 Katarzyna Krasińska
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ExOrg/php-data-coder
 */
class PreconfiguredSeriesLoader
{
  private string $configFilePath;
  private array $replacements = [];

  /**
   * Configure config file path.
   *
   * @param string $configFilePath
   * @throws \InvalidArgumentException
   */
  public function __construct(string $configFilePath)
  {
      self::validateFilePath($configFilePath);
      $this->configFilePath = $configFilePath;
  }

  public function setReplacements(array $replacements)
  {
    $this->replacements = $replacements;
  }

  public function load(): array {
    $configContent = file_get_contents($this->configFilePath);

    list($to_replace, $replace_with) = $this->prepareReplacements();

    $configContentWithReplacements = str_replace(
      $to_replace,
      $replace_with,
      $configContent
    );

    $series = Yaml::parse($configContentWithReplacements);

    return $series;
  }

  /**
   * Validate file path
   * and check if it can be used
   * to define file.
   *
   * @param string $path
   * @throws \InvalidArgumentException
   */
  private static function validateFilePath($path)
  {
      if (!is_string($path)) {
          throw new \InvalidArgumentException(
              'File path must be string.'
          );
      } elseif (empty($path)) {
          throw new \InvalidArgumentException(
              'File path cannot be empty.'
          );
      }
  }

  private function prepareReplacements(): array {
    $to_replace = array_keys($this->replacements);
    array_walk($to_replace, function(&$value, $key) {
      $value = "[[$value]]";
    });

    $replace_with = array_values($this->replacements);

    return [$to_replace, $replace_with];
  }
}
