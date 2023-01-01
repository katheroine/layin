<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Katheroine\Layin\Preconfiguration\LayoutsBoardPreconfiguredPageRenderer;

$pageRenderer = new LayoutsBoardPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('one_column.layin');

echo $pageRenderer->render();
