<?php

declare(strict_types=1);

namespace Recruitment\Entity;

use Recruitment\Cart\Collection\ItemCollection;
use Recruitment\Cart\Item;

class Order
{

    /** @var int  */
    private $id;

    /** @var ItemCollection  */
    private $items;

    /** @var int */
    private $totalPrice;

    /** @var int */
    private $totalPriceGross;

    /**
     * Order constructor.
     * @param int $orderId
     * @param ItemCollection $items
     */
    public function __construct(int $orderId, ItemCollection $items)
    {
        $this->id = $orderId;
        $this->items = $items;

        /** @var Item $item */
        foreach ($this->items->getCollectionItems() as $item) {
            $this->totalPrice += $item->getTotalPrice();
            $this->totalPriceGross += $item->getTotalPriceGross();
        }
    }

    /**
     * @return array
     */
    public function getDataForView(): array
    {
        return [
            'id' => $this->id,
            'items' => $this->items->toArray(),
            'total_price' => $this->totalPrice,
            'total_price_gross' => $this->totalPriceGross,
        ];
    }
}
