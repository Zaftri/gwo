<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    /** @var array  */
    private $availableTaxes = [
        0, 5, 8, 23
    ];

    /** @var int */
    private $id;

    /** @var int */
    private $unitPrice;

    /** @var int  */
    private $minimumQuantity = 1;

    /** @var int  */
    private $tax = 0;

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): Product
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $tax
     * @return Product
     */
    public function setTax(int $tax): Product
    {
        if (\in_array($tax, $this->availableTaxes)) {
            $this->tax = $tax;
            return $this;
        }

        throw new \InvalidArgumentException('Invalid tax');
    }

    /**
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice): Product
    {
        if (0 === $unitPrice) {
            throw new InvalidUnitPriceException();
        }

        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $minimumQuantity
     * @return Product
     */
    public function setMinimumQuantity(int $minimumQuantity = 1): Product
    {
        if (0 === $minimumQuantity) {
            throw new \InvalidArgumentException();
        }

        $this->minimumQuantity = $minimumQuantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'price' => $this->unitPrice,
            'minimumQuantity' => $this->minimumQuantity,
            'tax' => $this->tax,
        ];
    }
}
