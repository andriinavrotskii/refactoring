<?php

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new DI\ContainerBuilder();
$container = $containerBuilder
    ->addDefinitions([
        \Task\Repository\BinListRepositoryInterface::class => \Task\Repository\BinListRepository::class,
        \Task\Repository\CacheRepositoryInterface::class => \Task\Repository\CacheRepository::class,
        \Task\Repository\ExchangeRateRepositoryInterface::class => \Task\Repository\ExchangeRateRepository::class,
        \Psr\Log\LoggerInterface::class => \Task\Log\InlineLog::class,
    ])
    ->build();

$command = $container->get(Task\Command\TransactionCommissionsCommand::class);

list($script, $param) = $argv;

$command->run(__DIR__ . '/' .$param);
