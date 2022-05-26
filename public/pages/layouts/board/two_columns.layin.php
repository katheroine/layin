<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';

use Layin\VioletPageRenderer;

$pageRenderer = new VioletPageRenderer();
$pageRenderer
  ->setBaseRelativeUrl('../../..')
  ->setSubpagesRelativeUrl('../../../pages')
  ->setConfigDirRelativePath('../../../../config')
  ->setAssetsDirRelativePath('../../../assets')
  ->setTemplatesDirAbsolutePath(__DIR__ . '/../../../templates')
  ->setCodeFileExtension('php')
  ->setIsDebugMode(false)
  ->setTemplateName('layouts/board/two_columns.layin.twig.html');

$pageRenderer->render();
