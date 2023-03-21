<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Katheroine\Layin\Preconfiguration\ContentPreconfiguredPageRenderer;

$pageRenderer = new ContentPreconfiguredPageRenderer();
$pageRenderer->setTemplateName('article.layin');

echo $pageRenderer->render();
