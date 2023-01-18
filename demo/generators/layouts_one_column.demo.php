<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Katheroine\Layin\Demo\LayoutsPreconfiguredPageRenderer;

$pageRenderer = new LayoutsPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('one_column.layin');

echo $pageRenderer->render();
