<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../../templates');
$twig = new Environment($loader, ['debug' => true]);

$template = $twig->load('layouts/board/three_columns.twig.html');
echo $template->render([
  'base_url' => '../../../..',
  'subpages_url' => '../../../demo',
  'assets_dir' => '../../..',
  'code_file_extension' => 'html',
  'debug' => false,
]);
