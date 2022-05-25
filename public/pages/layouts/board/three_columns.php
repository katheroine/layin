<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Layin\PageRenderer;

$pageRenderer = new PageRenderer();
$pageRenderer
  ->setBaseRelativeUrl('../../..')
  ->setSubpagesRelativeUrl('../../../pages')
  ->setConfigDirRelativePath('../../../../config')
  ->setAssetsDirRelativePath('../../../assets')
  ->setTemplatesDirAbsolutePath(__DIR__ . '/../../../templates')
  ->setCodeFileExtension('php')
  ->setIsDebugMode(false)
  ->setTemplateName('layouts/board/three_columns.twig.html');

$pageRenderer->render();
