<?php

$config = new SlamCsFixer\Config([
    'php_unit_data_provider_name' => false,
    'php_unit_data_provider_return_type' => false,
]);
$config->getFinder()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->notPath('TestAsset/')
;

return $config;
