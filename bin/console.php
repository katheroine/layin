#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Layin\Console\CommandHandler;

$commandHandler = new CommandHandler;
$commandHandler->handleCommand($argv);
