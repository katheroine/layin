<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Symfony\Component\Yaml\Yaml;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, ['debug' => true]);

$site_config = Yaml::parseFile('../../config/site_config.yaml');

$navigation_links_config_file_path = '../../config/navigation_links.yaml';
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

$contact_info_links_config_file_path = '../../config/contact_info_links.yaml';
$contact_info_links_config_content = file_get_contents($contact_info_links_config_file_path);
$contact_info_links = Yaml::parse($contact_info_links_config_content);

$template_params = array_merge(
  $site_config,
  [
    'subpages_url' => './pages',
    'assets_dir' => '../assets',
    'navigation_links' => $navigation_links,
    'contact_info_links' => $contact_info_links,
    'debug' => false,
  ]
);

$template = $twig->load('index.default.twig.html');
echo $template->render($template_params);
