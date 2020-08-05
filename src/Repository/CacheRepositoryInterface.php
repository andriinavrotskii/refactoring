<?php

declare(strict_types=1);

namespace Task\Repository;

use Task\Exception\NotFoundException;

interface CacheRepositoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function setToStorage($key, $value): void;

    /**
     * @param mixed $key
     * @return mixed
     * @throws NotFoundException
     */
    public function getFromStorage($key);

    /**
     * @param mixed $key
     * @return bool
     */
    public function isKeyExists($key): bool;
}