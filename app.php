<?php

require __DIR__ . '/vendor/autoload.php';

$container = new DI\Container();

$command = $container->get(Task\Command\TransactionCommissionsCommand::class);

$command->run();
