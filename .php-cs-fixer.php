<?php

$config = new SlamCsFixer\Config();
$config->getFinder()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->notPath('TestAsset/')
;

return $config;
