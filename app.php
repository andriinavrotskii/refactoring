<?php

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new DI\ContainerBuilder();
$container = $containerBuilder
    ->addDefinitions([
        \Task\Repository\BinListRepositoryInterface::class
            => DI\get(\Task\Repository\BinListRepository::class),
        \Task\Repository\CacheRepositoryInterface::class
            => DI\get(\Task\Repository\CacheRepository::class),
        \Task\Repository\ExchangeRateRepositoryInterface::class
            => DI\get(\Task\Repository\ExchangeRateRepository::class),
        \Psr\Log\LoggerInterface::class
            => DI\get(\Task\Log\InlineLog::class),
    ])
    ->build();

$command = $container->get(Task\Command\TransactionCommissionsCommand::class);

$command->run($argv[1]);
