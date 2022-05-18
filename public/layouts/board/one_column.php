<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../../templates');
$twig = new Environment($loader, ['debug' => true]);

$template = $twig->load('layouts/board/one_column.twig.html');
echo $template->render([
  'base_url' => '../..',
  'subpages_url' => '../..',
  'assets_dir' => '../../assets',
  'code_file_extension' => 'php',
  'debug' => false,
]);
