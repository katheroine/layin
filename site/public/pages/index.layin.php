<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Katheroine\Layin\Preconfiguration\IndexPreconfiguredPageRenderer;

$pageRenderer = new IndexPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('index.layin');

echo $pageRenderer->render();
