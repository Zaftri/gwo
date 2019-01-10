<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Entity\Product;
use Recruitment\Entity\Order;
use Recruitment\Cart\Collection\ItemCollection;

class Cart
{
    /** @var ItemCollection */
    private $itemCollection;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->itemCollection = new ItemCollection();
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     */
    public function addProduct(Product $product, int $quantity = 1): Cart
    {
        $productId = $product->getId();

        if ($this->itemCollection->isExist($productId)) {
            $collectionItem = $this->itemCollection->getItem($productId);
            $collectionItem->addQuantity($quantity);

            $this->itemCollection->updateItem($collectionItem, $productId);

            return $this;
        }

        $item = new Item($product, $quantity);
        $this->itemCollection->addItem($item, $productId);

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->itemCollection->getCollectionItems();
    }

    /**
     * @param int $index
     * @return mixed
     * @throws \OutOfBoundsException
     */
    public function getItem(int $index): Item
    {
        if (0 <= $index && $this->itemCollection->isIndexExist($index)) {
            $itemArray = array_slice($this->itemCollection->getCollectionItems(), $index, 1);
            return reset($itemArray);
        }

        throw new \OutOfBoundsException();
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        $totalPrice = 0;

        /**  @var Item $item */
        foreach ($this->itemCollection->getCollectionItems() as $item) {
            $totalPrice += $item->getTotalPrice();
        }

        return $totalPrice;
    }

    /**
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $totalPriceGross = 0;

        /**  @var Item $item */
        foreach ($this->itemCollection->getCollectionItems() as $item) {
            $totalPriceGross += $item->getTotalPriceGross();
        }

        return $totalPriceGross;
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function removeProduct(Product $product): bool
    {
        if (!is_null($product->getId()) && $this->itemCollection->isExist($product->getId())) {
            $this->itemCollection->deleteItem($product->getId());
            return true;
        }

        return false;
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function setQuantity(Product $product, int $quantity): void
    {
        $productId = $product->getId();

        if ($this->itemCollection->isExist($productId)) {
            $collectionItem = $this->itemCollection->getItem($productId);
            $collectionItem->setQuantity($quantity);

            $this->itemCollection->updateItem($collectionItem, $productId);
        }

        $item = new Item($product, $quantity);
        $this->itemCollection->addItem($item, $productId);
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function checkout(int $orderId): Order
    {
        $order = new Order($orderId, $this->itemCollection);

        $this->itemCollection = new ItemCollection();

        return $order;
    }
}
