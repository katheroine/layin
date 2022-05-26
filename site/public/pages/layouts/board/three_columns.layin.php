<?php
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Layin\LayoutsBoardPreconfiguredPageRenderer;

$pageRenderer = new LayoutsBoardPreconfiguredPageRenderer();
$pageRenderer->renderPreconfiguredPage('layouts/board/three_columns.layin.twig.html');
