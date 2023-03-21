<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Katheroine\Layin\Demo\LayoutsPreconfiguredPageRenderer;

$pageRenderer = new LayoutsPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('three_columns.layin');

echo $pageRenderer->render();
