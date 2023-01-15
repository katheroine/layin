<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Katheroine\Layin\Preconfiguration\LayoutsContentPreconfiguredPageRenderer;

$pageRenderer = new LayoutsContentPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('content.layin');

echo $pageRenderer->render();
