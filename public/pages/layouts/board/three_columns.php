<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Symfony\Component\Yaml\Yaml;

$loader = new FilesystemLoader(__DIR__ . '/../../../templates');
$twig = new Environment($loader, ['debug' => true]);

$navigation_links_config_file_path = '../../../../config/navigation_links.yaml';
$navigation_links_config_content = file_get_contents($navigation_links_config_file_path);
$navigation_links_config_replacements = [
  '[[base_url]]' => '../../..',
  '[[code_file_extension]]' => 'php',
];
$navigation_links_config_content_prepared = str_replace(
  array_keys($navigation_links_config_replacements),
  array_values($navigation_links_config_replacements),
  $navigation_links_config_content
);
$navigation_links = Yaml::parse($navigation_links_config_content_prepared);

$template = $twig->load('layouts/board/three_columns.twig.html');
echo $template->render([
  'subpages_url' => '../..',
  'assets_dir' => '../../../assets',
  'navigation_links' => $navigation_links,
  'debug' => false,
]);
