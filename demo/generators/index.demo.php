<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../../public/templates');
$twig = new Environment($loader, ['debug' => true]);

$template = $twig->load('index.twig.html');
echo $template->render([
  'base_url' => '.',
  'subpages_url' => './demo',
  'assets_dir' => './public/assets',
  'code_file_extension' => 'html',
  'debug' => false,
]);
