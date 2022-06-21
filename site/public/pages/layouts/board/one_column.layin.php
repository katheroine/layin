<?php

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Katheroine\Layin\Preconfiguration\LayoutsBoardPreconfiguredPageRenderer;

$pageRenderer = new LayoutsBoardPreconfiguredPageRenderer();
$pageRenderer->renderPreconfiguredPage('one_column.layin.twig.html');
