<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Layin\PageRenderer;

$pageRenderer = new PageRenderer();
$pageRenderer
  ->setBaseRelativeUrl('..')
  ->setSubpagesRelativeUrl('pages')
  ->setConfigDirRelativePath('../../config')
  ->setAssetsDirRelativePath('../assets')
  ->setTemplatesDirAbsolutePath(__DIR__ . '/../../public/templates')
  ->setCodeFileExtension('php')
  ->setIsDebugMode(false)
  ->setTemplateName('index.default.twig.html');

$pageRenderer->render();
