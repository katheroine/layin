<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../../templates');
$twig = new Environment($loader, ['debug' => true]);

$template = $twig->load('index.twig.html');
echo $template->render([
  'base_url' => '.',
  'subpages_url' => './public/demo',
  'assets_dir' => './public',
  'code_file_extension' => 'html',
  'debug' => false,
]);
