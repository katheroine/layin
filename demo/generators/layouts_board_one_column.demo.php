<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../../public/templates');
$twig = new Environment($loader, ['debug' => true]);

$template = $twig->load('layouts/board/one_column.twig.html');
echo $template->render([
  'base_url' => '../../..',
  'subpages_url' => '../..',
  'assets_dir' => '../../../public/assets',
  'code_file_extension' => 'html',
  'debug' => false,
]);
