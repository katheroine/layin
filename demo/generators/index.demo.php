<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Katheroine\Layin\Demo\IndexPreconfiguredPageRenderer;

$pageRenderer = new IndexPreconfiguredPageRenderer();
$pageRenderer->renderPreconfiguredPage('index.layin.twig.html');
