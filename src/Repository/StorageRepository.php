<?php

namespace Task\Repository;

use Task\Exception\NotFoundException;

class StorageRepository
{
    /**
     * @var array
     */
    private $storage;

    public function __construct()
    {
        $this->storage = [];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function setToStorage($key, $value): void
    {
        $this->storage[$key] = $value;
    }

    /**
     * @param mixed $key
     * @return mixed
     * @throws NotFoundException
     */
    public function getFromStorage($key)
    {
        if ($this->isKeyExists($key)) {
            return $this->storage[$key];
        }

        throw new NotFoundException('Data not found for key: ' . (string) $key);
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function isKeyExists($key): bool
    {
        return array_key_exists($key, $this->storage);
    }
}