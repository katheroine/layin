<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Layin\VioletPageRenderer;

$pageRenderer = new VioletPageRenderer();
$pageRenderer
  ->setBaseRelativeUrl('..')
  ->setSubpagesRelativeUrl('pages')
  ->setConfigDirRelativePath('../../config')
  ->setAssetsDirRelativePath('../assets')
  ->setTemplatesDirAbsolutePath(__DIR__ . '/../../public/templates')
  ->setCodeFileExtension('php')
  ->setIsDebugMode(false)
  ->setTemplateName('index.layin.twig.html');

$pageRenderer->render();
