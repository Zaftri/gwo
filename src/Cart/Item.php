<?php

declare(strict_types=1);

namespace Recruitment\Cart;

use Recruitment\Entity\Product;
use Recruitment\Cart\Exception\QuantityTooLowException;

class Item
{
    /** @var int */
    private $quantity;

    /** @var Product */
    private $product;

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity = 1)
    {
        $this->product = $product;

        if ($quantity < $product->getMinimumQuantity()) {
            throw new \InvalidArgumentException();
        }

        $this->quantity = $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param int $quantity
     * @return $this
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): Item
    {
        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new QuantityTooLowException();
        }

        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function addQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->quantity * $this->product->getUnitPrice();
    }

    /**
     * @return int
     */
    public function getTotalPriceGross(): int
    {
        $totalPrice = $this->getTotalPrice();
        $tax = (int)round($totalPrice * ($this->product->getTax() / 100));

        return $totalPrice + $tax;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'quantity' => $this->quantity,
            'id' => $this->product->getId(),
            'total_price' => $this->getTotalPrice(),
            'total_price_gross' => $this->getTotalPriceGross(),
            'tax' => $this->product->getTax(),
        ];
    }
}
