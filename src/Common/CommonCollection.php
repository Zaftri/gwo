<?php

namespace Recruitment\Common;

class CommonCollection
{
    /** @var array */
    private $collection;

    /** @var string */
    private $collectionType;

    /**
     * CommonCollection constructor
     *
     * @param string $collectionType
     */
    public function __construct(string $collectionType)
    {
        $this->collection = [];
        $this->collectionType = $collectionType;
    }

    /**
     * @param object $collectionItem
     * @param int $key
     * @return bool
     * @throws \Exception
     */
    public function addItem(object $collectionItem, int $key): bool
    {
        if (!($collectionItem instanceof $this->collectionType)) {
            throw new \Exception('Invalit item type');
        }

        $this->collection[$key] = $collectionItem;

        return true;
    }

    /** @return int */
    public function count(): int
    {
        return count($this->collection);
    }

    /**  @return array */
    public function getCollectionItems(): array
    {
        return $this->collection;
    }

    /**
     * @param int $key
     * @return object
     * @throws \Exception
     */
    public function getItem(int $key): object
    {
        if (isset($this->collection[$key])) {
            return $this->collection[$key];
        }

        throw new \Exception('Invalid key');
    }

    /**
     * @param int $key
     * @return bool
     */
    public function deleteItem(int $key): bool
    {
        if (isset($this->collection[$key])) {
            unset($this->collection[$key]);
            return true;
        }

        return false;
    }

    /**
     * @param int $key
     * @return bool
     */
    public function isExist(int $key): bool
    {
        if (isset($this->collection[$key])) {
            return true;
        }

        return false;
    }

    /**
     * @param int $key
     * @return bool
     */
    public function isIndexExist(int $key): bool
    {
        $result = array_slice($this->collection, $key, 1);
        if (false !== $result && !empty($result)) {
            return true;
        }

        return false;
    }

    /**
     * @param object $item
     * @param int $key
     * @return bool
     */
    public function updateItem(object $item, int $key): bool
    {
        if (isset($this->collection[$key])) {
            $this->collection[$key] = $item;
            return true;
        }

        return false;
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->collection as $element) {
            $array[] = $element->toArray();
        }

        return $array;
    }
}
