<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Layin\Preconfiguration\LayoutsBoardPreconfiguredPageRenderer;

$pageRenderer = new LayoutsBoardPreconfiguredPageRenderer();
$pageRenderer->renderPreconfiguredPage('two_columns.layin.twig.html');
