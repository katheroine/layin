<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Katheroine\Layin\Demo\ContentPreconfiguredPageRenderer;

$pageRenderer = new ContentPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('article.layin');

echo $pageRenderer->render();
